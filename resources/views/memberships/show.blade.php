@extends('layouts.app')
@section('content')
    @include('layouts.partials._header')
    <div class="app-body">
        @include('layouts.partials._leftSideNav')
        <main class="main-content">
            <div class="page-title">
                <div class="row">
                    <h4 class="mb-0 mr-auto ml-3">{{$membership->title}} Membership</h4>
                </div>
            </div>
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12 mb-4 ui-sortable">
                        <div class="card ">
                            <div class="card-header">
                                <div class="card-title">Membership Fields</div>
                            </div>
                            <div class="card-body">
                                <table id="bs4-table" class="table table-bordered table-striped table-responsive-sm">
                                    <tbody>
                                    <tr>
                                        <th class="text-nowrap" scope="row">Membership Title</th>
                                        <td>{{$membership->title}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap" scope="row">Membership Description</th>
                                        <td>{{$membership->description}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap" scope="row">Price</th>
                                        <td>{{$membership->price}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap" scope="row">Status</th>
                                        <td>@if($membership->status == 1) Active @else InActive @endif</td>
                                    </tr>

                                    </tbody>
                                </table>
                                <div class="btn-demo">
                                    <a href="{{ URL::previous() }}" role="button"
                                       class="col-1 btn btn-info">Back</a>
                                    <a href="{{url('memberships/'.$membership->id.'/edit')}}"
                                       class="col-1 btn btn-warning">Edit</a>
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
