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

const app_uri = window.location.origin;
const params = Object.assign({}, queryToParams(window.location.search.substring(1)), queryToParams(window.location.hash.substring(1)));

const data =
{
    user_id: null,
    zoom_host_id: null,
    meeting_id: null,
    sync_state: null,
    database: null,
    itunes: null,
    spotify: null,
	deezer: null,
    zoom_meeting_id: null,
};

async function ready()
{
    log(params);

    firebase.initializeApp(firebaseConfig);
    data.database = firebase.firestore();

    data.user_id = parseInt(get('user-id').value);
    data.meeting_id = params.internal_meeting_id;
    data.zoom_meeting_id= params.meeting_id;
    data.zoom_host_id = await getZoomHost(data.meeting_id);
    data.sync_state = await getSyncState(data.meeting_id);
	console.log(data.sync_state);
}

// UI

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
		get('search_type').classList.remove('d-none');

        get('track-seek').removeAttribute('disabled');
        get('claim-host').classList.add('d-none');
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
		get('search_type').classList.add('d-none');

        get('track-seek').disabled = "true";

        if(data.zoom_host_id === data.user_id)
        {
            get('claim-host').classList.remove('d-none');
        }
    }
}

function search_pressed()
{
	//log(data);
	log(data.sync_state.store);
	if(data.sync_state.store === "itunes")
	{
		//log('searching itunes awesome.');
		search(get('search').value).then(result => updateTracksUI(result, "Search Results", 'itunes'));
	}
	else if(data.sync_state.store === "deezer")
	{
		searchDeezer(get('search').value).then(result => updateTracksUI(result, "Search Results", 'deezer'));
	}
	else
	{
		//console.log('calling search for '+ data.sync_state.store);
    	search(get('search').value, get('search_type').value).then(result => updateTracksUI(result, "Search Results", 'search'));
	}
}


function updateTracksUI(results, context_title, context)
{
	//log(results);
	let ids = [];
	get('context-title').innerHTML = context_title;
	//let tracks = shows = episodes = '';
	if(context == 'search')
	{
		console.log('inside update ui with search context');
		var index = 0;
		if(typeof results.tracks !== 'undefined' && results.tracks.items.length > 0)
		{
			console.log('inside tracks');
			get('tracks').innerHTML = "<h4>Songs</h4>";

			results.tracks.items.forEach((track, i) =>
			{
				ids.push(track.uri);
				//ids.push(track.id);
				get('tracks').innerHTML += `
				<div class="row" style="margin-bottom:5px;">
					<div class="col">
						<img src="${track.album.images[0].url}" height="40" width="40" />
						<a href="" onclick="track_clicked(${index}); return false;">${track.name} [${track.artists[0].name}]</a>
					</div>
				</div>
				`;
				index = index + 1;
			});
		}

		if(typeof results.episodes !== 'undefined' && results.episodes.items.length > 0)
		{
			console.log('inside episodes');
			get('tracks').innerHTML = "<h4>Episodes</h4>";
			results.episodes.items.forEach((track, i) =>
			{
				ids.push(track.uri);
				//ids.push(track.id);
				get('tracks').innerHTML += `
				<div class="row" style="margin-bottom:5px;">
					<div class="col">
						<img src="${track.images[0].url}" height="40" width="40" />
						<a href="" onclick="track_clicked(${index}); return false;">${track.name}</a>
					</div>
				</div>
				`;
				index = index + 1;
			});
		}

		if(typeof results.shows !== 'undefined' && results.shows.items.length > 0)
		{
			console.log('inside shows');
			get('tracks').innerHTML += "<h4>Shows</h4>";
			results.shows.items.forEach((track, i) =>
			{
				//ids.push(track.uri);
				//ids.push(track.id);
				get('tracks').innerHTML += `
				<div class="row" style="margin-bottom:5px;">
					<div class="col">
						<img src="${track.images[0].url}" height="40" width="40" />
						<a href="" onclick="playShowEpisodes('${track.uri}', ${i}, 0); return false;">${track.name}</a>
					</div>
				</div>
				`;
			});
		}

		//console.log('checking playlists count now.', playlists.length);
		if(typeof results.playlists !== 'undefined' && results.playlists.items.length > 0)
		{
			console.log('inside playlists');
			//console.log('hey I am here');
			get('tracks').innerHTML = "<h4>Playlists</h4>";

			results.playlists.items.forEach((list, i) =>
			{
				console.log(list.id);
				ids.push(list.id);
				//ids.push(track.id);
				get('tracks').innerHTML += `
				<div class="row" style="margin-bottom:5px;">
					<div class="col">
						<img src="${list.images[0].url}" height="40" width="40" />
						<a href="" onclick="playlist_clicked('${list.id}', '${list.name}'); return false;">${list.name} [Tracks: ${list.tracks.total}]</a>
					</div>
				</div>
				`;
				index = index + 1;
			});
		}
	}
	else if(context == 'play_list')
	{
		//log(results.items[0].track.name);
		get('tracks').innerHTML = "<h4>Songs</h4>";
		results.items.forEach((song, i) =>
		{
			//log(track.track.name);
			//get('tracks').innerHTML += `<div>${track.name} - ${i}</div`;
			ids.push(song.track.uri);
			get('tracks').innerHTML += `
			<div class="row" style="margin-bottom:5px;">
				<div class="col">
					<img src="${song.track.album.images[0].url}" height="40" width="40" />
					<a href="" onclick="track_clicked(${i}); return false;">${song.track.name} [${song.track.artists[0].name}]</a>
				</div>
			</div>
			`;
		});
	}
	else if(context == 'deezer')
	{
		if(results.data.length > 0)
		{
			get('tracks').innerHTML = "<h4></h4>";
			results.data.forEach((song, i) =>
			{
				const track = {id: song.id, name: song.title, duration: (song.duration * 1000), art: song.album.cover_big};
				ids.push(track);
				get('tracks').innerHTML += `
				<div class="row" style="margin-bottom:5px;">
					<div class="col">
						<img src="${song.album.cover_big}" height="40" width="40" />
						<a href="javascript:void(0)" onclick="track_clicked(${i}); return false;">${song.title} [${song.artist.name}]</a>
					</div>
				</div>
				`;
			});
		}
	}
	else
	{
		if(results.length > 0)
		{
			//let ids = [];
			get('tracks').innerHTML = "";

			results.forEach((track, i) =>
			{
				const img_url = (track.attributes.artwork.url).replace('{w}x{h}', '400x400');
				ids.push(track.id);
				//ids.push(track.id);
				get('tracks').innerHTML += `
				<div class="row" style="margin-bottom:5px;">
					<div class="col">
						<img src="${img_url}" height="40" width="40" />
						<a href="" onclick="track_clicked(${i}); return false;">${track.attributes.name} [${track.attributes.artistName}]</a>
					</div>
				</div>
				`;
				//index = index + 1;
			});
		}
	}
    data.ids = ids;
}

function updatePlaylistsUI(playlists)
{
    get('playlists').innerHTML = "";
    for (let playlist of playlists.items)
    {
        get('playlists').innerHTML += `
        <div class="row">
            <div class="col">
                <a href="" onclick="playlist_clicked('${playlist.id}', '${playlist.name}'); return false;">${playlist.name}</a>
            </div>
        </div>
        `;
    }
}

function updateLoginUI(me)
{
	console.log(me);
    if(me)
    {
        get('me').classList.remove('d-none');
        get('me').innerHTML = me.display_name;
        get('login').classList.add('d-none');
    }
    else
    {
        get('login').classList.remove('d-none');
        get('me').classList.add('d-none');
    }
}

function updateTrackUI(track)
{
	//console.log(track);
	if(typeof track.name !== 'undefined')
	{
		get('track-name').innerHTML = track.name
	}
	else
	{
		get('track-name').innerHTML = '';
	}
    get('track-seek').max 		= track.duration;
    if(typeof track.duration !== 'undefined' && !isNaN(track.duration))
	{
		get('track-duration').innerHTML = msToTime(track.duration)
	}
	else
	{
		get('track-duration').innerHTML = '00:00';
	}
    get('track-album-photo').src = (typeof track.art !== 'undefined') ? track.art : "https://via.placeholder.com/70/000000/000000";
}

function updatePlayerUI(state)
{
    updatePlayerStateUI(!state.paused);
    updateTrackUI(state.track_window.current_track.name, state.track_window.current_track.duration_ms, state.track_window.current_track.album.images[0]?.url);
    updateSeekUI(state.position);
    syncSeek(state.paused ? null : state.position);
}

function updatePlayerStateUI(state)
{
	get('player-toggle').innerHTML = `<a class="d-flex" onclick="player_toggle_clicked()" style="color: #4A4A4A; width:35px;height:35px;font-size:16px;border:2px solid;border-radius:50%;"><i class="m-auto fa ${state.is_playing ? 'fa-pause' : 'fa-play'}"></i></a>`;
}

function updateSeekUI(seek)
{
    get('track-time').innerHTML = msToTime(seek.position);
    get('track-seek').value = seek.position;
}

// APIs

// Synchronization

async function syncState()
{
    return new Promise(resolve =>
    {
        data.database.collection("meetings").doc(data.meeting_id).set(data.sync_state)
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
        data.database.collection("meetings").doc(data.meeting_id).get().then(async function (doc)
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
    data.database.collection("meetings").doc(data.meeting_id).onSnapshot(async function(doc)
    {
        let snapshot = doc.data();
        //log(snapshot);

        if(snapshot.host_id === data.user_id && snapshot.host_id === data.sync_state.host_id)
        {

        }
        else if(snapshot)
        {
			console.log('listenState else if condo.');
			console.log('snapshot host id', snapshot.host_id);
			console.log('data user id', data.user_id);
			console.log('data sync_state host id', data.sync_state.host_id);
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

// User events

function show_player_clicked(store)
{
	let old_script = get('store');
    let script = document.createElement('script');
    script.setAttribute("id","store");
    script.setAttribute("type","text/javascript");
    script.setAttribute("src", '../assets/js/' + store + '.js');
    old_script.parentNode.replaceChild(script, old_script);

    if(store == "spotify"){
        $("#login-icon").attr("src", "/assets/img/spotify-logo.png");
    }else if(store == "itunes"){
        $("#login-icon").attr("src", "/assets/img/itunes-logo.png");
    }else {
        $("#login-icon").attr("src", "/assets/img/deezer.png");
    }
    updateLoginUI(data[store]?.me);

    $("#music-popup").toggle();
    $("#close").toggle();
	if(data.sync_state?.store !== store)
    {
		console.log('new script is appended '+ script);
		data.sync_state.store = store;
	}
}

function hide_player_clicked()
{
    $("#music-popup").toggle();
    $("#close").toggle();
}

function login_clicked()
{
    login();
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
    if(id)
    {
		console.log('now host is', id);
        data.sync_state.host_id = id;
        syncState().then(updateHostUI);
        axios.get('/hostchange', { params: { zoom_meeting_id: data.zoom_meeting_id ,id:id,internal_meeting_id:data.meeting_id} }).then(resp =>
            {
                console.log('change_host');
            });
    }
}

async function playlist_clicked(id, playlist_name)
{
    getPlaylistTracks(id).then(tracks => updateTracksUI(tracks, playlist_name, 'play_list'));
}

function track_clicked(offset)
{
	play(data.ids, offset, 0).then();
}

function player_toggle_clicked()
{
    toggle();
}

function previous_clicked()
{
    //data.sync_state.playback.player.offset--;
    previous();
}

function next_clicked()
{
	//console.log('next_clicked was clicked');
    //data.sync_state.playback.player.offset++;
    next();
}

function seek_changed(value)
{
    seek(value);
}

function volume_changed(value)
{
	console.log('volume changed called');
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

window.onload = ready;
