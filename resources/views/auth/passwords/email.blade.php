@extends('layouts.app')

@section('title','Recovery Password')

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
                            @if (session('status'))
                                <div class="text-center">
                                    <a href="{{ route('home') }}">
                                    <span>
                                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="80">
                                    </span>
                                    </a>
                                </div>

                                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show mt-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    {{ session('status') }}
                                </div>
                            @else
                                <div class="text-center mb-4">
                                    <a href="{{ route('home') }}">
                                        <span><img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="80"></span>
                                    </a>
                                    <p class="text-muted mt-3">Enter your email address and we'll send you an email with instructions to reset your password.</p>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}" class="pt-2 parsley">
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

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-success btn-block" type="submit"> Send Reset Link</button>
                                </div>

                            </form>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p class="text-muted mb-0">Back to <a href="{{ route('login') }}" class="text-dark ml-1"><b>Log in</b></a></p>
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
