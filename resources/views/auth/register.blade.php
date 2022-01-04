 @extends('layouts.app')

 @section('content')
<div class="container">

    <form class="form-signin" method="POST" action="{{ route('register') }}">
        @csrf
        <a href="{{ url('/') }}" class="brand text-center">
            <img src="{{asset('assets/img/gta-logo.png')}}" alt="" height="100px">
        </a>
        <h2 class="form-signin-heading">Please sign up</h2>

        <div class="row">
            <div class="col-6">
              <div class="form-group">
                  <label for="firstName" class="sr-only">First Name</label>
                  <input type="text" id="firstName" class="form-control  @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
                  @error('first_name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
           </div>

            <div class="col-6">
              <div class="form-group">
                  <label for="lastName" class="sr-only">Last Name</label>
                  <input type="text" id="lastName" class="form-control  @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
                  @error('last_name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email address" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputPhone" class="sr-only">Phone No</label>
            <input type="number" id="inputPhone" class="form-control  @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Phone" required>
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control  @error('password') is-invalid @enderror" name="password" placeholder="Password" required>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputConfirmPassword" class="sr-only">Confirm Password</label>
            <input type="password" id="inputConfirmPassword" class="form-control"  name="password_confirmation" placeholder="Confirm Password" required>
        </div>

        <div class="checkbox mb-4 mt-4">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" name="term_and_conditions" class="custom-control-input" required>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">
                    I Agree the <a href="#" class="default-color">terms and conditions.</a>
                </span>
            </label><br>
            @if ($errors->has('term_and_conditions'))
            <span class="text-danger">
                <strong style="color: #dc3545;">{{ $errors->first('term_and_conditions') }}</strong>
            </span>
            @endif
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>

        <div class="mt-4">
            <span>
                Already have an account ?
            </span>
            <a href="{{ route('login')}}" class="text-primary">Sign In</a>
        </div>
    </form>

</div>
@endsection
