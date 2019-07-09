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
                                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="150">
                                    </span>
                                </a>
                            </div>

                            @if (session('resent'))
                                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    A fresh verification link has been sent to your email address.
                                </div>
                            @endif

                            Before proceeding, please check your email for a verification link.
                            If you did not receive the email, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
