const spotify_clientId = '28c1096484ed418fae2cb1f52e458730';
const spotify_scopes = 'streaming user-read-recently-played user-read-playback-position user-read-email user-library-read user-top-read playlist-modify-public ugc-image-upload user-follow-modify user-modify-playback-state user-read-private playlist-read-private user-library-modify playlist-read-collaborative playlist-modify-private user-follow-read user-read-playback-state user-read-currently-playing';

async function handleAccessToken(result)
{
    data.spotify = {};

    data.spotify.access_token = result;

    if(data.spotify.access_token)
    {
        data.spotify.me = await getMe();

        data.spotify.player = new Spotify.Player({ name: 'Grab The Aux', getOAuthToken: cb => { cb(data.spotify.access_token); } });
        data.spotify.player.addListener('player_state_changed', playerStateChanged);
        data.spotify.player.addListener('ready', async (device) =>
        {
            data.spotify.device = device;

            if(data.sync_state?.store !== 'spotify')
            {
                data.sync_state = {
                    host_id: data.zoom_host_id,
                    store: 'spotify',
                    playback: {
                        track: {

                        },
                        player: {

                        }
                    },
                };
            }

            updateLoginUI(data.spotify.me);
            updateHostUI();
            listenState();
            updatePlaylistsUI(await getPlaylists());
            await syncPlayer();
        });

        data.spotify.player.connect();
    }
}

// Synchronization

async function syncPlayer()
{
    if(data.sync_state?.store === 'spotify')
    {
        updateHostUI();
        updateTrackUI(data.sync_state.playback.track);

        data.spotify.player.getCurrentState().then(my_state =>
        {
            if(my_state)
            {
                if(data.sync_state.playback.player.is_playing)
                {
                    if(
                        my_state.paused ||
                        data.sync_state.playback.track.id !== my_state.track_window.current_track.uri ||
                        Math.abs(my_state.position - data.sync_state.playback.player.position) > 5000
                    )
                    {
                        play([data.sync_state.playback.track.id], 0, data.sync_state.playback.player.position);
                    }
                }
                else
                {
                    pause();
                }
            }
            else
            {
                if(data.sync_state.playback.player.is_playing)
                {
                    play([data.sync_state.playback.track.id], 0, data.sync_state.playback.player.position);
                }
                else
                {

                }
            }
        });
    }
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
    return data.spotify.player.pause();
}

function next()
{
    return data.spotify.player.nextTrack();
}

function previous()
{
    return data.spotify.player.previousTrack();
}

function seek(position)
{
    return data.spotify.player.seek(position);
}

function volume(volume)
{
    return data.spotify.player.setVolume(volume);
}

async function playerStateChanged(playback)
{
   // log(playback);

    if(playback)
    {
        let state = getPlaybackStateFromMediaPlayerState(playback);
        let track = getTrackFromMediaItem(playback.track_window.current_track);

        data.sync_state.playback.player = state;
        data.sync_state.playback.track = track;

        updatePlayerStateUI(state);
        updateTrackUI(track);
        await syncState();

        clearInterval(data.spotify.interval);
        if(data.sync_state.playback.player.is_playing)
        {
            data.spotify.interval = setInterval(() =>
            {
                data.sync_state.playback.player.position += 1000;
                updateSeekUI({position: data.sync_state.playback.player.position});
            }, 1000);
        }
    }
}

// APIs

async function login()
{
	log('spotify login');
    let spotify_params = {
        client_id: spotify_clientId,
        redirect_uri: app_uri + '/spotify',
        scope: spotify_scopes,
        response_type: 'token', // token | code
        state: data.meeting_id
    }

    let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=600,height=300,left=100,top=100`;
    window.open('https://accounts.spotify.com/authorize?' + paramsToQuery(spotify_params), 'test', params);
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
                request.setRequestHeader("Authorization", "Bearer " + data.spotify.access_token);
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

async function getPlaylists()
{
    return new Promise(resolve =>
    {
        $.ajax
        ({
            type: "GET",
            url: 'https://api.spotify.com/v1/me/playlists',
            beforeSend: function (request)
            {
                request.setRequestHeader("Authorization", "Bearer " + data.spotify.access_token);
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

async function getPlaylistTracks(playlist_id)
{
    return new Promise(resolve =>
    {
        $.ajax
        ({
            type: "GET",
            url: 'https://api.spotify.com/v1/playlists/' + playlist_id + '/tracks',
            beforeSend: function (request)
            {
                request.setRequestHeader("Authorization", "Bearer " + data.spotify.access_token);
            },
            success: function (response)
            {
                log(response);
                //resolve(response.items.map(item => getTrackFromMediaItem(item.track)));
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

async function search(q, type)
{
	//console.log('spotify search function was called. ');
	//var s_type = 'track';
	if(type === 'podcasts')
	{
		s_type = 'show,episode';
	}
	else
	{
		s_type = type;
	}
	
    return new Promise(resolve =>
    {
        $.ajax
        ({
            type: "GET",
            //url: 'https://api.spotify.com/v1/search?type=track,show,episode&limit=7&q='+q,
			url: 'https://api.spotify.com/v1/search?type='+s_type+'&limit=7&q='+q,
            beforeSend: function (request)
            {
                request.setRequestHeader("Authorization", "Bearer " + data.spotify.access_token);
            },
            success: function (response)
            {
                log(response);
                //resolve(response.tracks.items.map(item => getTrackFromMediaItem(item)));
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

async function playShowEpisodes(uri, offset_position, position_ms)
{
	 return new Promise(resolve =>
    {
        $.ajax
        ({
            type: 'PUT',
            url: `https://api.spotify.com/v1/me/player/play?device_id=${data.spotify.device.device_id}`,
            //data: JSON.stringify({ uris, offset: { position: offset_position }, position_ms }),
			data: JSON.stringify({ context_uri: uri, offset: { position: offset_position }, position_ms }),
            beforeSend: function (request)
            {
                request.setRequestHeader("Content-Type", "application/json");
                request.setRequestHeader("Authorization", "Bearer " + data.spotify.access_token);
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

async function play(uris, offset_position, position_ms)
{
	//log('this is uris');
	//log(uris);
	//log('these are offset');
	//log(offset_position);
    return new Promise(resolve =>
    {
        $.ajax
        ({
            type: 'PUT',
            url: `https://api.spotify.com/v1/me/player/play?device_id=${data.spotify.device.device_id}`,
            data: JSON.stringify({ uris, offset: { position: offset_position }, position_ms }),
			//data: JSON.stringify({ context_uri: uris[offset_position], offset: { position: offset_position }, position_ms }),
            beforeSend: function (request)
            {
                request.setRequestHeader("Content-Type", "application/json");
                request.setRequestHeader("Authorization", "Bearer " + data.spotify.access_token);
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

// Adapter

function getTrackFromMediaItem(item)
{
    return {
        id: item.uri,
        name: item.name,
        album: item.album.name,
        artist: item.artists.reduce((artists, artist) => artists ? (artists + ", " + artist.name) : artist.name, null),
        art: item.album.images[0]?.url,
        duration: item.duration_ms,
    }
}

function getPlaybackStateFromMediaPlayerState(state)
{
    return {
        is_playing: !state.paused,
        position: state.position
    }
}
