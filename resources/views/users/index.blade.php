
@extends('layouts.app')
@section('content')
    @include('layouts.partials._header')

    <div class="app-body">
        @include('layouts.partials._leftSideNav')
        <main class="main-content main_area_width">
            <div class="page-title">
                <div class="row">
                    <h4 class="mr-auto ml-3">Users</h4>
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
                                                <a href="{{url('users')}}">All Users</a>
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

@endsection
@push('scripts')
        {!! $dataTable->scripts() !!}
@endpush
