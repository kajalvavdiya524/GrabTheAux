const spotify_clientId = '28c1096484ed418fae2cb1f52e458730';
const spotify_scopes = 'streaming user-read-recently-played user-read-playback-position user-read-email user-library-read user-top-read playlist-modify-public ugc-image-upload user-follow-modify user-modify-playback-state user-read-private playlist-read-private user-library-modify playlist-read-collaborative playlist-modify-private user-follow-read user-read-playback-state user-read-currently-playing';

const firebaseConfig =
{
    apiKey: "AIzaSyB3uFgaoC4gwRGQ1TW40KvRyzQ67-yo7hY",
    authDomain: "grabtheaux-e62c0.firebaseapp.com",
    projectId: "grabtheaux-e62c0",
    storageBucket: "grabtheaux-e62c0.appspot.com",
    messagingSenderId: "331802067050",
    appId: "1:331802067050:web:859008092e7ef1523fca13",
    measurementId: "G-VY8BGM535D"
};

const app_uri = window.location.origin + window.location.pathname;
const params = Object.assign({}, queryToParams(window.location.search.substring(1)), queryToParams(window.location.hash.substring(1)));

let database = null;

const data =
{
    user_id: null,
    zoom_host_id: null,
    meeting_id: null,
    sync_state: null,
    spotify: null
};

async function sdkReady()
{
    log(params);

    // Order of statements in this function is important

    firebase.initializeApp(firebaseConfig);
    database = firebase.firestore();

    data.user_id = parseInt(get('user-id').value);
    data.meeting_id = params.meeting_id || params.state;
    data.zoom_host_id = await getZoomHost(data.meeting_id);
    data.sync_state = await getSyncState(data.meeting_id);

    if(params.access_token)
    {
        data.spotify = await connectSpotify();

        if(data.spotify)
        {
            syncPlayer();
            listenState();
        }
    }

    updateLoginUI(data.spotify?.me);
}

// Synchronization & UI

async function syncPlayer()
{
    if(data.sync_state)
    {
        updateHostUI();
        updateTrackUI(data.sync_state.playback.track.name, data.sync_state.playback.track.duration, data.sync_state.playback.track.image_url);

        data.spotify.player.getCurrentState().then(my_state =>
        {
            if(my_state)
            {
                if(data.sync_state.playback.player.is_paused)
                {
                    pause();
                }
                else
                {
                    if(
                        my_state.paused ||
                        data.sync_state.playback.track.uri !== my_state.track_window.current_track.uri ||
                        Math.abs((my_state.timestamp - data.sync_state.timestamp) - ( my_state.position - data.sync_state.playback.player.position )) > 10000
                    )
                    {
                        playTrack([data.sync_state.playback.track.uri], 0, data.sync_state.playback.player.position);
                    }
                }
            }
            else
            {
                if(data.sync_state.playback.player.is_paused)
                {

                }
                else
                {
                    playTrack([data.sync_state.playback.track.uri], 0, data.sync_state.playback.player.position);
                }
            }
        });
    }
    else if(data.zoom_host_id === data.user_id)
    {
        data.sync_state = { host_id: data.zoom_host_id };
        updateHostUI();
    }
}

function syncSeek(position)
{
    clearInterval(data.spotify.seek?.interval);

    if(position)
    {
        data.spotify.seek = {
            position: position,
            interval: setInterval(() => { data.spotify.seek.position += 1000; updateSeekUI(data.spotify.seek.position); }, 1000)
        };
    }
}

function updateHostUI()
{
    if(data.sync_state.host_id === data.user_id)
    {
        get('playlists').classList.remove('d-none');
        get('tracks').classList.remove('d-none');
        get('player-toggle').classList.remove('d-none');
        get('previous').classList.remove('d-none');
        get('next').classList.remove('d-none');
        get('host').classList.remove('d-none');
        get('search').classList.remove('d-none');

        get('track-seek').removeAttribute('disabled');
        get('claim-host').classList.add('d-none');

        getMyPlaylists().then(updatePlaylistsUI);
    }
    else
    {
        get('playlists').classList.add('d-none');
        get('tracks').classList.add('d-none');
        get('player-toggle').classList.add('d-none');
        get('previous').classList.add('d-none');
        get('next').classList.add('d-none');
        get('host').classList.add('d-none');
        get('search').classList.add('d-none');

        get('track-seek').disabled = "true";

        if(data.zoom_host_id === data.user_id)
        {
            get('claim-host').classList.remove('d-none');
        }
    }
}

function updateTracksUI(results, context_title)
{
	const tracks = results.tracks.items;
	const shows = results.shows.items;
	const episodes = results.episodes.items;
	let uris = [];
    get('context-title').innerHTML = context_title;
	if(tracks.length > 0)
	{
		get('tracks').innerHTML = "<h4>Songs</h4>";	
	
		tracks.forEach((track, i) =>
		{
			uris.push(track.uri);
			get('tracks').innerHTML += `
			<div class="row" style="margin-bottom:5px;">
				<div class="col">
					<img src="${track.album.images[0].url}" height="40" width="40" /> 
					<a href="" onclick="track_clicked(${i}); return false;">${track.name} (${track.artists[0].name})</a>
				</div>
			</div>
			`;
		});
	}
	if(shows.length > 0)
	{
		get('tracks').innerHTML += "<h4>Shows</h4>";
		let uris = [];
	
		shows.forEach((track, i) =>
		{
			uris.push(track.uri);
			get('tracks').innerHTML += `
			<div class="row" style="margin-bottom:5px;">
				<div class="col">
					<img src="${track.images[0].url}" height="40" width="40" /> 
					<a href="" onclick="track_clicked(${i}); return false;">${track.name}</a>
				</div>
			</div>
			`;
		});
	}
	if(episodes.length > 0)
	{
		get('tracks').innerHTML += "<h4>Episodes</h4>";
		let uris = [];
	
		episodes.forEach((track, i) =>
		{
			uris.push(track.uri);
			get('tracks').innerHTML += `
			<div class="row" style="margin-bottom:5px;">
				<div class="col">
					<img src="${track.images[0].url}" height="40" width="40" />
					<a href="" onclick="track_clicked(${i}); return false;">${track.name}</a>
				</div>
			</div>
			`;
		});
	}

    data.uris = uris;
}

function updatePlaylistsUI(playlists)
{
    get('playlists').innerHTML = "";
    for (let playlist of playlists.items)
    {
        get('playlists').innerHTML += `
        <div class="row">
            <div class="col">
                <a href="" onclick="playlist_clicked('${playlist.uri}', '${playlist.name}'); return false;">${playlist.name}</a>
            </div>
        </div>
        `;
    }
}

function updateLoginUI(me)
{
    if(me)
    {
        get('me').classList.remove('d-none');
        get('me').innerHTML = me.display_name;
    }
    else
    {
        get('login').classList.remove('d-none');
    }
}

function updateTrackUI(name, duration, url)
{
    get('track-name').innerHTML = name;
    get('track-seek').max = duration;
    get('track-duration').innerHTML = msToTime(duration);
    get('track-album-photo').src = url;
}

function updatePlayerUI(state)
{
    get('player-toggle').innerHTML = `<a class="d-flex" onclick="player_toggle_clicked()" style="color: #4A4A4A; width:35px;height:35px;font-size:16px;border:2px solid;border-radius:50%;"><i class="m-auto fa ${state.paused ? 'fa-play' : 'fa-pause'}"></i></a>`;
    updateTrackUI(state.track_window.current_track.name, state.track_window.current_track.duration_ms, state.track_window.current_track.album.images[0]?.url);
    updateSeekUI(state.position);
    syncSeek(state.paused ? null : state.position);
}

function updateSeekUI(position)
{
    get('track-time').innerHTML = msToTime(position);
    get('track-seek').value = position;
}

// Player

function toggle()
{
    return data.spotify.player.togglePlay();
}

function resume()
{
    return data.spotify.player.resume();
}

function pause()
{
    return data.spotify.player?.pause();
}

function next()
{
    return data.spotify.player?.nextTrack();
}

function previous()
{
    return data.spotify.player?.previousTrack();
}

function seek(position)
{
    return data.spotify.player.seek(position);
}

function volume(volume)
{
    return data.spotify.player.setVolume(volume);
}

async function playerStateChanged(state)
{
    log(state);

    if(state)
    {
        updatePlayerUI(state);

        if(data.sync_state.host_id == data.user_id)
        {
            data.sync_state.playback = {
                player: {
                    position: state.position,
                    is_paused: state.paused
                },
                track: {
                    uri: state.track_window.current_track.uri,
                    duration: state.track_window.current_track.duration_ms,
                    name: state.track_window.current_track.name,
                    image_url: state.track_window.current_track.album.images[0]?.url
                }
            };

            data.sync_state.timestamp = state.timestamp;

            await syncState();
        }
    }
}

// APIs

async function syncState()
{
    return new Promise(resolve =>
    {
        database.collection("meetings").doc(data.meeting_id).set(data.sync_state)
            .then(function ()
            {
                resolve(true);
            })
            .catch(function (error)
            {
                log(error);
                resolve(false);
            });
    });
}

async function getSyncState()
{
    return new Promise(resolve =>
    {
        database.collection("meetings").doc(data.meeting_id).get().then(async function (doc)
        {
            if (doc.exists)
            {
                let state = doc.data();
                log(state);
                resolve(state);
            }
            else
            {
                log("No such document!");
                resolve(null);
            }
        });
    });
}

function listenState()
{
    database.collection("meetings").doc(data.meeting_id).onSnapshot(async function(doc)
    {
        let snapshot = doc.data();
        log(snapshot);

        if(snapshot.host_id === data.user_id && snapshot.host_id === data.sync_state.host_id)
        {
        }
        else if(snapshot)
        {
            data.sync_state = snapshot;
            await syncPlayer();
        }
    });
}

function getZoomHost()
{
    return new Promise(resolve =>
    {
        axios.get('/participants', { params: { id: data.meeting_id, onlyhost: true } }).then(resp =>
        {
            console.log(resp.data);
            resolve(resp.data.participants[0].user.id);
        });
    });
}

async function getMe()
{
    return new Promise(resolve =>
    {
        $.ajax
        ({
            type: "GET",
            url: 'https://api.spotify.com/v1/me',
            beforeSend: function (request)
            {
                request.setRequestHeader("Authorization", "Bearer " + params.access_token);
            },
            success: function (response)
            {
                log(response);
                resolve(response);
            },
            error: function (xhr, ajaxOptions, thrownError)
            {
                log(xhr);
                log(ajaxOptions);
                log(thrownError);

                // if (xhr.responseJSON.status = 401)
                // {
                //     login_clicked();
                // }

                resolve(null);
            }
        });
    });
}

async function getMyPlaylists()
{
    return new Promise(resolve =>
    {
        $.ajax
        ({
            type: "GET",
            url: 'https://api.spotify.com/v1/me/playlists',
            beforeSend: function (request)
            {
                request.setRequestHeader("Authorization", "Bearer " + params.access_token);
            },
            success: function (response)
            {
                log(response);
                resolve(response);
            },
            error: function (xhr, ajaxOptions, thrownError)
            {
                log(xhr);
                log(ajaxOptions);
                log(thrownError);

                resolve(null);
            }
        });
    });
}

async function getURIData(uri)
{
    let [spotify, type, id] = uri.split(":");
    switch (type)
    {
        case "playlist":
            return await getMyPlaylistTracks(id);
            break;
    }
}

async function getMyPlaylistTracks(playlist_id)
{
    return new Promise(resolve =>
    {
        $.ajax
        ({
            type: "GET",
            url: 'https://api.spotify.com/v1/playlists/' + playlist_id + '/tracks',
            beforeSend: function (request)
            {
                request.setRequestHeader("Authorization", "Bearer " + params.access_token);
            },
            success: function (response)
            {
                log(response);
                resolve(response);
            },
            error: function (xhr, ajaxOptions, thrownError)
            {
                log(xhr);
                log(ajaxOptions);
                log(thrownError);
                resolve(null);
            }
        });
    });
}

async function getSearchTracks(q)
{
    return new Promise(resolve =>
    {
        $.ajax
        ({
            type: "GET",
            url: 'https://api.spotify.com/v1/search?type=track,show,episode&limit=7&q='+q,
            beforeSend: function (request)
            {
                request.setRequestHeader("Authorization", "Bearer " + params.access_token);
            },
            success: function (response)
            {
                log(response);
                resolve(response);
            },
            error: function (xhr, ajaxOptions, thrownError)
            {
                log(xhr);
                log(ajaxOptions);
                log(thrownError);
                resolve(null);
            }
        });
    });
}

async function playTrack(uris, offset_position, position_ms)
{
    return new Promise(resolve =>
    {
        $.ajax
        ({
            type: 'PUT',
            url: `https://api.spotify.com/v1/me/player/play?device_id=${data.spotify.device.device_id}`,
            data: JSON.stringify({ uris, offset: { position: offset_position }, position_ms }),
            beforeSend: function (request)
            {
                request.setRequestHeader("Content-Type", "application/json");
                request.setRequestHeader("Authorization", "Bearer " + params.access_token);
            },
            success: function ()
            {
                resolve(true);
            },
            error: function (xhr, ajaxOptions, thrownError)
            {
                log(xhr);
                log(ajaxOptions);
                log(thrownError);
                resolve(false);
            }
        });
    });
}

async function connectSpotify()
{
    let me = await getMe();
    let player = new Spotify.Player({ name: 'Grab The Aux', getOAuthToken: cb => { cb(params.access_token); } });

    return new Promise(resolve =>
    {
        // Error handling
        player.addListener('initialization_error', () => resolve(null));
        player.addListener('account_error', () => resolve(null));
        player.addListener('authentication_error', () => resolve(null));
        player.addListener('playback_error', () => resolve(null));

        // Not Ready
        player.addListener('not_ready', () => resolve(null));

        // Playback status updates
        player.addListener('player_state_changed', playerStateChanged);

        // Ready
        player.addListener('ready', (device) => { resolve({ me, player, device }); } );

        // Connect to the player!
        player.connect();
    });
}

// User events

function login_clicked()
{
    let spotify_params = {
        client_id: spotify_clientId,
        redirect_uri: app_uri,
        scope: spotify_scopes,
        response_type: 'token', // token | code
        state: data.meeting_id
    }
	//console.log('here');

    redirect('https://accounts.spotify.com/authorize', spotify_params);
}

function search_pressed()
{
    //getSearchTracks(get('search').value).then(result => updateTracksUI(result.tracks.items, "Search Results"));
	getSearchTracks(get('search').value).then(result => updateTracksUI(result, "Search Results"));
}

function claim_host_clicked()
{
    data.sync_state.host_id = data.zoom_host_id;
    syncState().then(updateHostUI);
}

function change_host_clicked()
{
    axios.get('/participants', { params: { id: data.meeting_id } }).then(resp =>
    {
        $("ul.participants").html("");
        $.each(resp.data.participants, function (catalog_key, catalog_val)
        {
            $("ul.participants").append($(`<div class="row"><div class="col"><a href="" onclick="host_clicked(${catalog_val.user.id}); return false;">${catalog_val.user.first_name + " " + catalog_val.user.last_name}</a></div></div>`));
        });
    });
}

async function host_clicked(id)
{
    if (id)
    {
        data.sync_state.host_id = parseInt(id);
        syncState().then(updateHostUI);
    }
}

function playlist_clicked(uri, playlist_name)
{
    getURIData(uri).then((tracks) => updateTracksUI(tracks.items.map(item => item.track), playlist_name));
}

function track_clicked(offset)
{
    playTrack(data.uris, offset, 0).then();
}

function player_toggle_clicked()
{
    toggle();
}

function previous_clicked()
{
    data.sync_state.playback.player.offset--;
    previous();
}

function next_clicked()
{
    data.sync_state.playback.player.offset++;
    next();
}

function seek_changed(value)
{
    seek(value);
}

function volume_changed(value)
{
    volume(value);
}

// Helpers

function msToTime(s)
{
    let ms = s % 1000;
    s = (s - ms) / 1000;
    let secs = s % 60;
    s = (s - secs) / 60;
    let mins = s % 60;
    let hrs = (s - mins) / 60;

    return (hrs > 0 ? ((hrs < 10 ? '0' + hrs : hrs) + ':') : '') + (mins < 10 ? '0' + mins : mins) + ':' + (secs < 10 ? '0' + secs : secs);
}

function sleep(n)
{
    return new Promise(resolve => setTimeout(resolve, n));
}

function get(id)
{
    return document.getElementById(id);
}

function redirect(path, params)
{
	//console.log(path);
    window.location.href = path + "?" + paramsToQuery(params);
}

function queryToParams(query)
{
    let params = {};
    for (const [key, value] of new URLSearchParams(query).entries())
    {
        params[key] = encodeURIComponent(value);
    }

    return params;
}

function paramsToQuery(params)
{
    return $.param(params);
}

function copy(text)
{
    let textfield = document.getElementById(text);
    textfield.select();
    textfield.setSelectionRange(0, 99999);
    document.execCommand("copy");
}

function log(data)
{
    console.log(data);
}

