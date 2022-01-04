@extends('layouts.vu')
@section('content')


    <div class="app-body">
        <main class="main-content">

            <div class="container-fluid">

                <div class="row">
                        <meeting-component :meeting_id="'{{$meeting_id}}'" :passcode="'{{$passcode}}'"
                                           :username="'{{$username}}'" :leave="'{{$leaveURL}}'" :userEmail="'{{$userEmail}}'"
                                           :role="'{{$role}}'">
                        </meeting-component>
                </div>
                <div class="row" id="menu">
                    <div class="col-lg-6">
                        <button class="btn btn-success menu-btn" onclick="show_player_clicked('spotify')">
                        	<img src="{{ asset('assets/img/spotify-logo.png') }}"> Spotify
                        </button>
                        <button class="btn btn-success menu-btn" onclick="show_player_clicked('itunes')">
                        	<img src="{{ asset('assets/img/itunes-logo.png') }}"> iTunes
                        </button>
                        <button class="btn btn-default menu-btn" onclick="show_player_clicked('deezer')">
                        	<img src="{{ asset('assets/img/deezer.png') }}"> Deezer
                        </button>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-outline-theme right-btn menu-btn" onclick="inviteParticipants()">Invite via Email</button>
                        <button class="btn btn-outline-theme right-btn menu-btn mr-2" onclick="copy_clicked()">Copy Meeting URL</button>
                    </div>
                </div>



                <div class="spotify-section vh-93" id="music-popup">
                    <button id = "close" onclick="hide_player_clicked()">X</button>

                    <div class="row text-white" style="height: 60px; background: #030924;">
                        <div class="col-3 my-auto">
                            <span id="me" class="d-none"></span>
                        </div>
                        <div class="col my-auto">
                            <form class="my-0 form-inline" onsubmit="search_pressed(); return false;">
                                <input id="search" class="text-left form-control" style="width:80%; z-index: 9999;
                                " type="text" value="" placeholder="search"/>
                                <select class="form-control" name="search_type" id="search_type" style="width:0%;">
                                	<option value="track" selected="selected">Music</option>
                                    <option value="playlist">Playlists</option>
                                    <option value="podcasts">Podcasts</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-3 my-auto">
                            <div class="row">
                                <div id="claim-host" class="col-auto d-none">
                                    <a class="btn" style="color: #ffffff; border-color: #ffffff; background:rgb(77,76,89);" onclick="claim_host_clicked(); return false;">Claim Host</a>
                                </div>
                                <div id="host" class="col-auto d-none">
                                    <a class="btn" data-toggle="modal" data-target=".bd-participants-modal-sm" onclick="change_host_clicked(); return false;" style="color: #ffffff; border-color: #ffffff; background:rgb(77,76,89);">Change Host</a>
                                </div>
                                <div id="login" class="col-auto d-none">
                                    <a class="btn btn-success" onclick="login_clicked(); return false;"><img id="login-icon" src="" style="padding-right: 5px;">Login</a>
                                </div>
                            </div>
                        </div>
                        <input id="user-id" type="hidden" value="{{Auth::user()->id}}"/>
                    </div>

                    <div class="row bg-inverse h-72">

                        <div class="col h-100 px-3" style="background: linear-gradient(90deg, rgba(77,76,89,1) 34%, rgba(2,0,36,1) 93%);">

                            <div class="row text-white" style="height: 40px">
                                <div class="col-lg-3 col-md-2 col-sm-1 col-xs-1">
                                    <h4>Playlists</h4>
                                </div>
                                <div class="col-lg-8 col-md-7 col-sm-6 col-xs-6">
                                    <h4 id="context-title"></h4>
                                </div>
                            </div>

                            <div class="row text-white h-100" style="margin-top: -40px; padding-top: 40px">
                                <div id="playlists" class="col-lg-3 col-md-2 col-sm-1 col-xs-1 h-100 overflow-auto d-none">
                                </div>
                                <div id="tracks" class="col-lg-8 col-md-7 col-sm-6 col-xs-6 h-100 overflow-auto d-none">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row text-white pad-for-col" style="height: 100px; background: #030924;">
                    <div id="dz-root" style="display:none;"></div>


                        <div class="col-3 d-flex">
                            <div class="row h-100">
                                <div class="col-auto my-auto">
                                    <img id="track-album-photo" src="https://via.placeholder.com/70/000000/000000" style="width: 70px; height: 70px;">
                                </div>
                                <div class="col my-auto">
                                    <span id="track-name" class=""></span>
                                </div>
                            </div>
                        </div>


                        <div class="col d-flex">
                            <div class="row px-3 my-auto w-100">
                                <div class="col">
                                    <div class="row mb-2">
                                        <div class="col"></div>
                                        <div id="previous" class="d-none col-auto my-auto">
                                            <a class="d-flex" onclick="previous_clicked()" style="color: #4A4A4A; width:35px;height:35px;font-size:16px;border:2px solid;border-radius:50%;">
                                                <i class="m-auto fa fa-step-backward"></i>
                                            </a>
                                        </div>
                                        <div id="player-toggle" class="d-none col-auto my-auto">
                                            <a class="d-flex" onclick="player_toggle_clicked()" style="color: #4A4A4A; width:35px;height:35px;font-size:16px;border:2px solid;border-radius:50%;">
                                                <i class="m-auto fa fa-play"></i>
                                            </a>
                                        </div>
                                        <div id="next" class="d-none col-auto my-auto">
                                            <a class="d-flex" onclick="next_clicked()" style="color: #4A4A4A; width:35px;height:35px;font-size:16px;border:2px solid;border-radius:50%;">
                                                <i class="m-auto fa fa-step-forward"></i>
                                            </a>
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-auto my-auto">
                                            <span id="track-time" class="">00:00</span>
                                        </div>
                                        <div class="col my-auto">
                                            <input id="track-seek" disabled="true" type="range" onchange="seek_changed(this.value)" oninput="seek_changed(this.value)" class="slider" id="slider" min="0" max="0" step="1">
                                        </div>
                                        <div class="col-auto my-auto">
                                            <span id="track-duration" class="">00:00</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-3 d-flex">
                            <div class="row h-100 ml-auto mr-0">
                                <div class="col-auto my-auto">
                                    <input id="volume" type="range" onchange="volume_changed(this.value)" oninput="volume_changed(this.value)" class="slider" id="slider" min="0" max="1" step="0.01" style="width:50%">
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

                <div id="part" class="modal fade bd-participants-modal-sm"
                     tabindex="-1" role="dialog"
                     aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">
                                    Participants </h4>
                                <button type="button" class="close"
                                        data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul class="participants list-group" style="list-style-type:none;">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
@endsection
<style>
    #playlists a {
        color: white !important;
    }
    #playlists a:hover {
        color: #337ab7 !important;
    }
    #tracks a {
        color: white !important;
    }
    #tracks a:hover {
        color: #337ab7 !important;
    }
</style>
@push('vue_scripts')
    <link href="{{asset('assets/css/meeting.css')}}" rel="stylesheet">

	<script src="https://e-cdns-files.dzcdn.net/js/min/dz.js"></script>
    <script src="https://kit.fontawesome.com/b0da9b8fda.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://sdk.scdn.co/spotify-player.js"></script>
    <script src="https://js-cdn.music.apple.com/musickit/v1/musickit.js"></script>


    <!-- Firebase setup -->
    <script src="https://www.gstatic.com/firebasejs/8.2.4/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.2.4/firebase-firestore.js"></script>


    <script src="{{asset('assets/js/adpater.js')}}"></script>
    <script id="store"></script>

    <script src="{{ mix('js/app.js') }}" defer type="text/javascript"></script>


@endpush
<script>
    var inviteDom ;
    var popupDom ;

    function inviteParticipants()
    {
         inviteDom = window.open('/invite','popUpWindowInvite','height=510,width=500,left=400,top=150,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
    }

    function copy_clicked()
    {
        let url_params = {
            meeting_id: params.meeting_id,
            passcode: params.passcode,
            internal_meeting_id: params.internal_meeting_id
        }
        let url = window.location.origin + window.location.pathname + '?' + paramsToQuery(url_params);
        navigator.clipboard.writeText(url);
        console.log(url);
    }

</script>
