
@extends('layouts.app')
@section('content')
    @include('layouts.partials._header')

    <div class="app-body">
        @include('layouts.partials._leftSideNav')
        <main class="main-content main_area_width">
          <div class="page-title">
              <div class="row">
                  <h4 class="mr-auto ml-3">Meetings</h4>
                  <div class="mr-2">
                    <a href="{{url('meetings/join')}}" class="ml-auto btn btn-primary btn-block text-white px-4"><i
                            class="fa fa-video-camera mr-2"></i>Join Meeting</a>
                </div>
                <div class="mr-2">
                    <?php echo session()->get('code'); ?>
                    <form method="get" id="createMeeting" onsubmit="createMeeing(event)"> 
                        <!-- action="{{url('meetings/check-meeting')}}" -->
                            <button type="submit" class="btn btn-danger btn-block ml-auto text-white px-4"><i class="fa fa-plus mr-2"></i>Create New Meeting</button>
                    </form>
              </div>
              </div>
          </div>
            @if(count($errors))
                <div class="col-12">
                    <ul class="alert alert-danger ">
                        @foreach($errors->all() as $error)
                            <li class="ml-4">{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="container-fluid">

                <div class="row">

                    <div class=" col-12">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                            <div class="card card-shadow mb-4">
                                <div class="card-header">
                                    <div class="row">

                                    <div class="col-6">
                                        <div class="ml-uato ml-3">
                                            <div class="card-title">
                                                <a href="{{url('meetings')}}">All Meetings</a>
                                            </div>
                                        </div>
                                    </div>

                                    </div>

                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        {!! $dataTable->table(['class'=>'table']) !!}
                                    </div>
                                </div>

                            </div>
                    </div>
                </div>
            </div>
            @include('layouts.partials._footer')
        </main>
    </div>
<script>
function createMeeing(e) {
    e.preventDefault();
    $.ajax
    ({
        type: 'GET',
        url: `meetings/auth-zoom-verification`,
        success: function (res)
        {
            window.open(res.redirect_url, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes')
        },
        error: function (xhr, ajaxOptions, thrownError)
        {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        }
    });
}
</script>
@endsection
@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush



