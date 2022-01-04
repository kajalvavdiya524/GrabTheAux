const itunes_developer_token = 'eyJhbGciOiJFUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IjU3ODVWNkQ2TTIifQ.eyJpYXQiOjE2MTQ3ODI0ODksImV4cCI6MTYzMDMzNDQ4OSwiaXNzIjoiOTM1NEpaRDRSViJ9.kMZsH1abQ0rm64AT3h_XF31wIEoWhtXS_szDLry0KFhEyAV7SKAGxkZC39ztIUxN272BzX-8ykKGpIylkAYRaA';

async function handleLogin(result)
{
    data.itunes = {};

    data.itunes.kit = result;

    if(data.itunes.kit)
    {
        data.itunes.me = { display_name: "No Name" };

        data.itunes.kit.player.addEventListener("playbackStateDidChange", playbackStateDidChange);
        data.itunes.kit.player.addEventListener("mediaItemDidChange", mediaItemDidChange);
        data.itunes.kit.player.addEventListener("playbackTimeDidChange", playbackTimeDidChange);

        if(data.sync_state?.store !== 'itunes')
        {
            data.sync_state = {
                host_id: data.zoom_host_id,
                store: 'itunes',
                playback: {
                    track: {

                    },
                    player: {

                    }
                },
            };
        }

        updateHostUI();
        updateLoginUI(data.itunes.me);
        listenState();
        await syncPlayer();
    }
}

// Synchronization

async function syncPlayer()
{
    if(data.sync_state?.store === 'itunes')
    {
        updateHostUI();
        updateTrackUI(data.sync_state.playback.track);

        if(data.sync_state.playback.player.is_playing)
        {
            if(
                !data.itunes.kit.player.isPlaying ||
                data.sync_state.playback.track.id !== data.itunes.kit.player.nowPlayingItem.id ||
                Math.abs(data.itunes.kit.player.currentPlaybackTime - data.sync_state.playback.player.position) > 5000
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

// Player

function toggle()
{
    return data.itunes.kit.player.isPlaying ? pause() : resume();
}

function resume()
{
    return data.itunes.kit.player.play();
}

function pause()
{
    return data.itunes.kit.player.pause();
}

function next()
{
    return data.itunes.kit.player.skipToNextItem();
}

function previous()
{
    return data.itunes.kit.player.skipToPreviousItem();
}

function seek(position)
{
    return data.itunes.kit.player.seekToTime(position / 1000);
}

function volume(volume)
{
    return data.spotify.player.setVolume(volume);
}

// Events

async function playbackStateDidChange(playback)
{
    //log(playback);

    if(playback)
    {
        let state = getPlaybackStateFromMediaPlayerState(playback.state);
        data.sync_state.playback.player.is_playing = state.is_playing;
        updatePlayerStateUI(state);
        await syncState();
    }
}

async function mediaItemDidChange(item)
{
    //log(item);

    if(item)
    {
        let track = getTrackFromMediaItem(item.item);
        data.sync_state.playback.track = track;
        updateTrackUI(track);
        await syncState();
    }
}

async function playbackTimeDidChange(time)
{
    //log(time);

    if(time)
    {
        let seek = getSeekProgressFromMediaPlayerTime(time);
        data.sync_state.playback.player.position = seek.position;
        updateSeekUI(seek);
        //syncState();
    }
}

// APIs

async function login()
{
	log('itunes login');
    MusicKit.configure({ developerToken: itunes_developer_token, app: { name: 'Grab The Aux', build: '1.0' } });
    MusicKit.getInstance().authorize().then(() => handleLogin(MusicKit.getInstance())).catch(e => { log(e); });
}

async function search(q)
{
	//log(q);
	const { songs } = await data.itunes.kit.api.search(q, {
	  types: ["songs", "albums"],
	  limit: 25,	  
	});
	//const songs = await data.itunes.kit.api.search(q, { types: "albums", limit: 15 });
	log(songs.data);
    return songs.data
}

async function play(ids, offset_position, position_ms)
{
	//log('here man');
	//log(ids, offset_position);
    return new Promise(resolve =>
    {
        data.itunes.kit.setQueue({ songs: ids }).then(async function()
        {
            await data.itunes.kit.changeToMediaAtIndex(offset_position);
            seek(position_ms);
        });
    });
}

// Adapter

function getTrackFromMediaItem(item)
{
    return {
        id: item.id,
        name: item.attributes.name,
        album: item.attributes.albumName,
        artist: item.attributes.artistName,
        art: item.attributes.artwork?.url,
        duration: item.attributes.durationInMillis,
    }
}

function getPlaybackStateFromMediaPlayerState(state)
{
    return {
        is_playing: state === 2
    }
}

function getSeekProgressFromMediaPlayerTime(time)
{
    return {
        position: time.currentPlaybackTime * 1000
    }
}
