async function initDeezer()
{
	DZ.init(
	{
		//appId  : '481882',
		//channelUrl : 'http://localhost:8001/deezer_channel',
		appId  : '480402',
		channelUrl : 'http://aux.ashlarhq.com/deezer_channel',
		
		player : 
		{
			onload : onPlayerLoaded
		}
	});
}

function onPlayerLoaded() 
{
	console.log('DZ Player is ready');
	DZ.Event.subscribe('current_track', function(arg)
	{
		//event_listener_append('current_track', arg.index, arg.track.title, arg.track.album.title);
		console.log('current_track', arg);
	});
	
	DZ.Event.subscribe('player_position', function(arg)
	{
		//event_listener_append('position', arg[0], arg[1]);
		//console.log('position', arg[0], arg[1]);
		const r_time = Math.round(arg[0]);
		const seek_time = r_time * 1000;
		data.sync_state.playback.player.position = r_time;
		//console.log('Player position event', data.sync_state.playback.player.is_playing);
		//seek(seek_time);
		updateSeekUI({position: seek_time});
		
    });
	
	/*DZ.Event.subscribe('track_end', function() 
	{
		//event_listener_append('track_end');
		console.log('track_end');
	});*/
	
	DZ.Event.subscribe('player_play', function(evt_name)
	{
		console.log('player play event called');
		console.log('current song position is @ ', data.sync_state.playback.player.position);
		
		const offset = DZ.player.getCurrentIndex();
		track = data.ids[offset];
		
		data.sync_state.playback.player.is_playing = DZ.player.isPlaying();
		data.sync_state.playback.track = track;
		
		updateTrackUI(track);
		updatePlayerStateUI({is_playing: DZ.player.isPlaying()});
		syncState();
	});
	
	DZ.Event.subscribe('player_paused', function(evt_name)
	{
		console.log('Player paused', evt_name);
		console.log('player paused @ ', data.sync_state.playback.player.position);
		data.sync_state.playback.player.is_playing = DZ.player.isPlaying();
		updatePlayerStateUI({is_playing: DZ.player.isPlaying()});
		syncState();
	});
}

async function processLogin()
{
	DZ.login(function(response) 
	{
		if(response.authResponse) 
		{
			DZ.api('/user/me', function(rsp) 
			{
				//console.log(rsp);
				data.deezer.me = { display_name: rsp.name };
				if(data.sync_state?.store !== 'deezer')
				{
					data.sync_state = 
					{
						host_id: data.zoom_host_id,
						store: "deezer",
						playback: {
							track: {
			
							},
							player: {
			
							}
						},
					};
				}
				
				
				//console.log(data);
				updateHostUI();
				updateLoginUI(data.deezer.me);
				var playlist = [];
				DZ.api('/user/me/playlists', function(rsp)
				{
					//console.log(rsp.data);
					rsp.data.forEach((list, i) => 
					{
						playlist.push({id: list.id, name: list.title});
					});
					//console.log(rsp.id, rsp.title, rsp.duration);
					updatePlaylistsUI({items: playlist});
				});
				listenState();
				//data.deezer.Events = DZ.Event;
				syncPlayer();
			});
			
		}
		else 
		{
			//console.log('User cancelled login or did not fully authorize.');
			alert('User cancelled login or did not fully authorize.');
		}
	}, {perms: 'basic_access, email'});
}

async function login()
{
	log('deezer login');	
	data.deezer = {};
	initDeezer().then(processLogin());	
}

async function getPlaylistTracks(playlist_id)
{
	var items = [];
    return new Promise(resolve =>
    {
		DZ.api('/playlist/'+playlist_id+'/tracks', function(rsp) 
		{
			rsp.data.forEach((song, i) =>
			{
				//console.log(song.id+' '+song.title);
				const clicked_track = {id: song.id, name: song.title, duration: (song.duration * 1000), art: song.album.cover_big}
				const track = {track: {uri: clicked_track, artists: [{name: song.artist.name}], album: {images: [{url: song.album.cover_big}]}, name: song.title}};
				items.push(track)
			});
			const final = {items: items};
			//console.log(final);
			resolve(final);
		});
    });
}

// APIs
async function searchDeezer(q)
{
	//console.log('deezer search function was called');
    return new Promise(resolve =>
    {		
		DZ.api('/search?q='+q, function(rsp)
		{
			console.log(rsp);
			resolve(rsp);
		});
    });
}

async function syncPlayer()
{
    if(data.sync_state?.store === 'deezer')
    {
        updateHostUI();
        updateTrackUI(data.sync_state.playback.track);
		//console.log('inside deezer sync player and deezer condo');
		//console.log(data.sync_state.playback.player.is_playing);
		if(data.sync_state.playback.player.is_playing)
		{
			console.log(data.sync_state.playback.player);
			/*if(data.sync_state.playback.player.position > 0)
			{
				resume();
			}
			else
			{*/
				//const new_pos = 1000 * data.sync_state.playback.player.position;
				//updateSeekUI({position: new_pos});
				console.log('player was called with ', data.sync_state.playback.player.position);
				play([data.sync_state.playback.track], 0, data.sync_state.playback.player.position);
				
			/*}*/
		}
		else
		{
			//console.log('paused was called from here.');
			//console.log(data.sync_state.playback.player);
			pause();
		}
	 }
}

async function play(ids, offset_position, position_ms)
{
	//console.log(ids, 'playing this');
	//return false;
	track = ids[offset_position];
	//console.log(track);
	updateTrackUI(track);
	const track_ids = [];
	ids.forEach((song, i) => 
	{
		track_ids.push(song.id);
	});
	//DZ.player.playTracks(track_ids, offset_position, position_ms);
	return new Promise(resolve =>
    {
        DZ.player.playTracks(track_ids, offset_position, position_ms);		
		//(autoplay, index, callback, offset) 
		//DZ.player.playTracks(track_ids, offset_position);		
    });
	
	
	/*if(position_ms && position_ms > 0)
	{
		seek(position_ms);
	}*/
	//console.log(track_ids);
	//return data.deezer.player.setVolume(real_vol)
}

function toggle()
{
	if (DZ.player.isPlaying()) 
	{
		return DZ.player.pause()
	}
	else 
	{
		return DZ.player.play()
	}
}

function resume()
{
    return DZ.player.play();
}

function pause()
{
    //return data.deezer.player.DZ.player.pause();
	return DZ.player.pause();
}

function next()
{
	const offset = DZ.player.getCurrentIndex() + 1;
	track = data.ids[offset];
	updateTrackUI(track);
	return DZ.player.next();
}

function previous()
{
	const offset = DZ.player.getCurrentIndex() - 1;
	if(offset < 0)
	{
		offset = 0;
	}
	track = data.ids[offset];
	updateTrackUI(track);
    return DZ.player.prev();
}

function seek(position)
{
	//console.log('seek current position ' + position);
	updateSeekUI({position: position});
	const offset = DZ.player.getCurrentIndex();
	track = data.ids[offset];
	
	//const state_pos = Math.round(position / 1000);
	//data.sync_state.playback.player.position = state_pos;
	
	const dur_ms_to_sec = position ;
	const new_pos = Math.round(100*dur_ms_to_sec/track.duration);
	//position = Math.round((100*(position/1000)/track.duration));
	//syncState();
	console.log('seeks called with ' + new_pos);	
    return DZ.player.seek(new_pos);
}

function volume(volume)
{
	const real_vol = (volume*100);
	//console.log('deezers volumn called with volume ' + real_vol);
    return DZ.player.setVolume(real_vol)
}