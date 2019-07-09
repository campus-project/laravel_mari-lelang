@extends('layouts.app')

@section('title','Sign Up')

@section('bodyClass', 'authentication-bg authentication-bg-pattern d-flex align-items-center')

@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('home') }}">
            <i class="fas fa-home h2 text-white"></i>
        </a>
    </div>

    <div class="account-pages w-100 mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <a href="{{ route('home') }}">
                                    <span>
                                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="28">
                                    </span>
                                </a>
                            </div>

                            <form method="POST" action="{{ route('register') }}" class="pt-2 parsley">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}" parsley-trigger="change" required>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Email address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" parsley-type="email" parsley-trigger="change" required>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your password" parsley-trigger="change" required>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password_confirmation">Password Confirmation <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Type password again" data-parsley-equalto="#password" parsley-trigger="change" required>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signup" name="term" {{ old('term') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-dark">Terms and Conditions</a></label>

                                    @if($errors->has('term'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>The term of service must be accepted.</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-success btn-block" type="submit"> Register</button>
                                </div>

                            </form>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p class="text-muted mb-0">Already have account?  <a href="{{ route('login') }}" class="text-dark ml-1"><b>Sign In</b></a></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalJs')
    <script>
        $(document).ready(function(){
            $(".parsley").parsley()
        });
    </script>
@endsection
