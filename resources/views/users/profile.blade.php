@extends('layouts.app')
@section('content')
    @include('layouts.partials._header')

    <!--===========app body start===========-->
    <div class="app-body">
    @include('layouts.partials._leftSideNav')
        <!--main contents start-->
        <main class="main-content">

            <!--profile heading start-->
            <div class="bg-dark profile-img mb-4 text-light d-flex align-items-end">
                <div class="container-fluid">
                    <div class="row mb-4 pt-5 pb-3 d-flex align-items-end">
                        <div class="col-md-6">
                            <div class="media mb-4">
                                <img class="align-self-center mr-3 rounded-circle" src="{{ asset('assets/img/user3.png') }}" alt="profile user" width="45">
                                <div class="media-body mt-1 profile-text-shadow">
                                    <strong class="f18">{{ $user->first_name }}</strong>
                                    <p class="mb-0 f12">{{ $user->last_name }}</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="text-lg-right profile-text-shadow">
                                <div class="d-inline-block px-3 text-center text-light">
                                    <strong class="f24 d-block">34234</strong>
                                    <small>Auctions</small>
                                </div>
                                <div class="d-inline-block px-3 text-center text-light">
                                    <strong class="f24 d-block">5445</strong>
                                    <small>Lots</small>
                                </div>
                                <div class="d-inline-block px-3 text-center text-light">
                                    <strong class="f24 d-block">545</strong>
                                    <small>Companies</small>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

            </div>
            <!--profile heading end-->

            <div class="container-fluid">
                <!-- state start-->

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row">

                    <div class=" col-md-6">
                        <!--profile timeline start-->
                        <div class="card card-shadow mb-4">
                            <div class="card-header">
                                <div class="card-title">
                                  User Stats
                                </div>
                            </div>
                            <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-8">
                                            <strong>
                                                <p>Role:</p>
                                            </strong>
                                        </div>
                                        <div class="col-md text-left">
                                            <p>{{$user->roles[0]->name}}</p>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-8">
                                            <strong>
                                                <p>Email:</p>
                                            </strong>
                                        </div>
                                        <div class="col-md text-left">
                                            <p>{{$user->email}}</p>
                                        </div>
                                    </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <strong>
                                            <p>Membership: </p>
                                        </strong>
                                    </div>
                                    <div class="col-md text-left">
                                        {{$user->membership ? $user->membership->title : 'No Membership'}}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--profile timeline end-->
                    </div>

                    <div class=" col-md-6">
                        <!--profile timeline start-->
                        <div class="card card-shadow mb-4">
                            <div class="card-header">
                                <div class="card-title">
                                   Software Stats
                                </div>
                            </div>
                            <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-8">
                                            <strong>
                                                <p>Total Membership</p>
                                            </strong>
                                        </div>
                                        <div class="col-md text-left">
                                            <p>{{$total_memberships}}</p>
                                        </div>
                                    </div>


                                <div class="row">
                                    <div class="col-md-8">
                                        <strong>
                                            <p>Total User: </p>
                                        </strong>
                                    </div>

                                    <div class="col-md text-left">
                                        <p>{{$total_users}}</p>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-8">
                                        <strong>
                                            <p>Total Meetings: </p>
                                        </strong>
                                    </div>

                                    <div class="col-md text-left">
                                        <p>2</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--profile timeline end-->
                    </div>


                </div>
                <!-- state end-->

            </div>
        </main>
        <!--main contents end-->


    </div>
    <!--===========app body end===========-->

    @include('layouts.partials._footer')

@endsection
