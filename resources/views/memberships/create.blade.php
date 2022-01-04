
@extends('layouts.app')
@section('content')
    @include('layouts.partials._header')
    <div class="app-body">
        @include('layouts.partials._leftSideNav')
        <main class="main-content">
            <div class="page-title">
                <h5 class="mb-0">Add Membership</h5>
            </div>
            @if (session('success'))
                <div class="container-fluid">
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
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
                    <div class=" col-md-12">
                        <div class="container">
                            <form method="post" action="{{url('memberships')}}" enctype="multipart/form-data">
                                @csrf
                                {{-- <div class="row ml-3">
                                    <h5>Add Membership</h5>
                                </div> --}}
                                <div class="row">

                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputName" class="col-md-2 col-form-label">Title:</label>
                                        <div class="col-md-12">
                                            <input type="text" name="title" class="form-control" id="inputName" placeholder="Membership Title" value="{{ old('title') }}">
                                        </div>
                                    </div>
                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputLocation" class="col-md-12 col-form-label">Price:</label>
                                        <div class="col-md-12">
                                            <input type="number" name="price" class="form-control" id="inputAuctionNo" placeholder="Price" value="{{ old('price') }}" required>
                                        </div>
                                    </div>
                                 </div>

                              </div>

                                    <div class="form-group">
                                        <label for="inputLocation" class="col-md-2 col-form-label">Description:</label>
                                        <div class="col-md-12">
                                            <input type="text" name="description" class="form-control" id="inputDescription" placeholder="Membership Description" value="{{ old('description') }}">
                                            {{--@if ($errors->has('description'))--}}
                                                {{--<label class="text-danger error">{{ $errors->first('description') }}</label>--}}
                                            {{--@endif--}}
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="status" class="col-md-2 col-form-label">Status:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" id="status" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">In Active</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <a href="{{url('memberships')}}"
                                           class="btn btn-warning ml-3">Cancel</a>
                                        <button type="submit" class="btn btn-success ml-3">Submit</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
              @include('layouts.partials._footer')
        </main>
    </div>

@endsection
