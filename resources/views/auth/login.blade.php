@extends('layouts.app')

@section('title','Login')

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

                            <form method="POST" action="{{ route('login') }}" class="pt-2 parsley">
                                @csrf

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
                                    <a href="{{ route('password.request') }}" class="text-muted float-right"><small>Forgot your password?</small></a>
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your password" parsley-trigger="change" required>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-success btn-block" type="submit"> Log In</button>
                                </div>

                            </form>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p class="text-muted mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-dark ml-1"><b>Sign Up</b></a></p>
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
