
@extends('layouts.app')
@section('content')
    @include('layouts.partials._header')

    <div class="app-body">
        @include('layouts.partials._leftSideNav')
        <main class="main-content main_area_width">
            <div class="page-title">
                <div class="row">
                    <h4 class="mr-auto ml-3">Membership Payment</h4>
                    <div class=" ml-auto mr-2">
                      {{-- <a href="{{url('memberships/create')}}" class="ml-auto btn btn-danger btn-block text-white px-4"><i
                              class="fa fa-plus mr-2"></i>Create New Membership</a> --}}
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
                      @if (session('msg'))
                          <div class="alert alert-primary" role="alert">
                              {{ session('msg') }}
                          </div>
                      @endif
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
                                                <a href="{{url('payment-detail-membership/'.$membership->id)}}">Payment Detail</a>
                                            </div>
                                        </div>
                                    </div>

                                    </div>

                                </div>

                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h4 class="card-title">Credit Card Information</h4>

                                                    <br>
                                                    <form action="{{url('payment-membership/'.$membership->id)}}" method="POST" id="payment-form">
                                                      @csrf
                                                      <div id="card-element" style="border: 1px solid lightgrey; padding:20px;">
                                                      <!-- A Stripe Element will be inserted here. -->
                                                      </div>
                                                      <div id="card-errors" role="alert" style="color: red;"></div>

                                                      <div class="form-button" style="float:right; padding-top:10px">
                                                      <button class="btn btn-danger" id="submit_charge" type="submit">Submit</button>
                                                      </div>
                                                    </form>

                                                    {{-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                    <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h4 class="card-title">Membership Details</h4>
                                                    <h5 class="card-title">{{$membership->title}} Membership (${{$membership->price}})</h5>
                                                    <p class="card-text"><b>Description:</b> {{$membership->description}}</p>
                                                </div>
                                            </div>
                                        </div>

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
<script src="https://js.stripe.com/v3/"></script>
<script>
    var publishable_key = '{{ config('stripe.stripe_key') }}';
</script>
<script src="{{ asset('/assets/js/stripe.js') }}"></script>
@endpush
