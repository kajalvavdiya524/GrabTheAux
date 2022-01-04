@extends('layouts.vu')
@section('content')

    <div class="container-fluid vh-100">

        <div class="row fixed-top text-white" style="min-width: 720px; height: 60px; background: #030924;">
            <div class="col-3 my-auto">
                <span id="me" class="d-none"></span>
            </div>
            <div class="col my-auto">
                <form class="my-0" onsubmit="search_pressed(); return false;">
                    <input id="search" class="text-center form-control" style="max-width: 500px; z-index: 9999;
                    " type="text" value="" placeholder="Search songs, shows or episodes."/>
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
                    <div id="login" class="col-auto  d-none">
                        <a class="btn btn-success" onclick="login_clicked(); return false;"><img src="{{ asset('assets/img/spotify-logo.png') }}" style="padding-right: 5px;">Spotify Login</a>
                    </div>
                </div>
            </div>
            <input id="user-id" type="hidden" value="{{Auth::user()->id}}"/>
        </div>

        <div class="row bg-inverse h-100" style="min-width: 720px; padding-top: 60px; padding-bottom: 100px;">

            <div class="col h-100 px-3" style="background: linear-gradient(90deg, rgba(77,76,89,1) 34%, rgba(2,0,36,1) 93%);">

                <div class="row text-white" style="height: 40px">
                    <div class="col-lg-4 col-md-3 col-sm-2 col-xs-2">
                        <h4>Playlists</h4>
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-6 col-xs-6">
                        <h3 id="context-title"></h3>
                    </div>
                </div>

                <div class="row text-white h-100" style="margin-top: -40px; padding-top: 40px">
                    <div id="playlists" class="col-lg-4 col-md-3 col-sm-2 col-xs-2 h-100 overflow-auto d-none">
                    </div>
                    <div id="tracks" class="col-lg-8 col-md-7 col-sm-6 col-xs-6 h-100 overflow-auto d-none">
                    </div>
                </div>

            </div>

        </div>

        <div class="row fixed-bottom text-white" style="min-width: 720px; height: 100px; background: #030924;">


            <div class="col-3 d-flex">
                <div class="row h-100">
                    <div class="col-auto my-auto">
                        <img id="track-album-photo" style="width: 70px; height: 70px;">
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

    <!--Participants modal-->
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
    <!-- end Participants modal-->

@endsection

@push('vue_scripts')

@endpush
<script>

    window.onload=(function()
    {
        var hash = location.hash.substring(1);
        var accessString = hash.indexOf("&");
        access_token = hash.substring(13, accessString);
        closePopup(access_token);
    });

    function closePopup(token)
    {
        try
        {
            window.opener.handleAccessToken( token );
        }
        catch (err) {}
        window.close();
        return false;
    }
</script>
