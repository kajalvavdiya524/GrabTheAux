
@extends('layouts.app')
@section('content')
    @include('layouts.partials._header')
    <div class="app-body">
          @include('layouts.partials._leftSideNav')
          <main class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class=" col-md-12">

                      <div class="jumbotron jumbotron-fluid">
                          <div class="container">
                            <h1 class="display-4" style="padding-left: 30%">Join Meeting</h1>
                            <p class="lead">Please Enter Meeting URL</p>
                              <div class="form-group">
                                <input type="text" name="meeting_url" id="meeting_url" placeholder="Meeting URL" class="form-control" id="inputAuctionNo" required>
                              </div>

                                <div class="form-group">
                                  <a href="{{url('meetings')}}"
                                     class="btn btn-warning ml-3">Cancel</a>
                                    <button type="button" class="btn btn-success ml-3" onclick="joinMeeting()">Submit</button>
                                </div>
                          </div>
                        </div>

                        </div>
                    </div>
            </div>
              @include('layouts.partials._footer')
        </main>
    </div>

@endsection
@push('vue_scripts')
    <script>
        function joinMeeting(){

            window.location.href = document.getElementById('meeting_url').value;
        }
    </script>
@endpush
