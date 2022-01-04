
@extends('layouts.app')
@section('content')
    @include('layouts.partials._header')
    <div class="app-body">


        @include('layouts.partials._leftSideNav')
        <main class="main-content">

            <div class="container-fluid">
                <div class="row">
                    <div class=" col-md-12">
                        {{-- <div class="container"> --}}
                            {{-- <div class="card card-shadow mb-4"> --}}


                                {{-- <div class="card-body" >
                                    <div class="table-responsive"> --}}
                                        {{-- <meeting-component></meeting-component>  --}}
                                    {{-- </div>
                                </div> --}}

                            {{-- </div> --}}
                            {{-- <meeting-component></meeting-component> --}}
                            <form method="get" action="{{url('meetings/create-zoom')}}">
                                  <div class="row">
                                      <input type="hidden" name="name" value="{{auth()->user()->first_name}}">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                          <label for="inputLocation" class="col-md-12 col-form-label">Zoom Meeting ID:</label>
                                          <div class="col-md-12">
                                              <input type="number" name="meeting_id" class="form-control" id="inputAuctionNo" value="4146784515" readonly required>
                                          </div>
                                      </div>
                                   </div>

                                    <div class="col-md-4">
                                      <div class="form-group">
                                          <label for="inputLocation" class="col-md-12 col-form-label">Zoom Meeting Passcode:</label>
                                          <div class="col-md-12">
                                              <input type="password" name="passcode" class="form-control" id="inputAuctionNo" placeholder="PassCode" value="D7gQ7d" readonly required>
                                          <input type="hidden" name="created_by_id" value="{{auth()->user()->id}}">

                                          </div>
                                      </div>
                                    </div>

                                </div>


                                    <div class="form-group">
                                        <a href="{{url('meetings')}}"
                                           class="btn btn-warning ml-3">Cancel</a>
                                        <button type="submit" class="btn btn-success ml-3">Submit</button>
                                    </div>
                            </form>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
              @include('layouts.partials._footer')
        </main>
    </div>

@endsection
@push('vue_scripts')
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
@endpush
