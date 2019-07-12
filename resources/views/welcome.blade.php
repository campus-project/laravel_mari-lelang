@extends('layouts.landing')

@section('content')
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark">
        <div class="container-fluid">
            <!-- LOGO -->
            <a class="logo text-uppercase" href="{{ route('welcome') }}">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" class="logo-light" height="40" />
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" class="logo-dark" height="40" />
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto navbar-center" id="mySidenav">
                    <li class="nav-item active">
                        <a href="#home" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#services" class="nav-link">Services</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link">Contact</a>
                    </li>
                </ul>
                @if(Auth::check())
                    <a href="{{ route('home') }}" class="btn btn-sm btn-primary btn-rounded navbar-btn">Home</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary btn-rounded navbar-btn mr-1">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary btn-rounded navbar-btn">Register Now</a>
                @endif
            </div>
        </div>
    </nav>

    <section class="bg-home bg-gradient" id="home">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div class="home-title text-white">
                        <h4 class="mb-3 text-white-50">{{ config('app.name', 'Laravel') }}</h4>
                        <h1 class="text-white mb-4">If it is easy, why should it be complicated</h1>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="home-img mt-5 mt-lg-0">
                        <img src="{{ asset('images/home-img.png') }}" alt="" class="img-fluid mx-auto d-block">
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-pattern-effect">
            <img src="{{ asset('images/bg-pattern.png') }}" alt="">
        </div>
    </section>

    <section class="section" id="services">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="title text-center mb-5">
                        <h3 class="mb-3">{{ config('app.name') }}</h3>
                        <p>Our Service</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="card services-box">
                        <div class="card-body p-4">
                            <div class="services-icon mb-3">
                                <i class="pe-7s-notebook h3 mt-0"></i>
                            </div>
                            <h4 class="mb-3">Snipe auctions at the last second</h4>
                            <p class="text-justify">We have put together a system that will place your bids 24 hours a day, 7 days a week at the last possible second. FREE accounts will have their bids placed around 10 seconds before the auction closes and paying customers can select as little as 3 seconds.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card services-box">
                        <div class="card-body p-4">
                            <div class="services-icon mb-3">
                                <i class="pe-7s-display1 h3 mt-0"></i>
                            </div>
                            <h4 class="mb-3">Server Service</h4>
                            <p class="text-justify">Our servers run 24 hours a day, 7 days a week and place your bids while your are away from your computer. Thanks to our advanced bid placing engine you can sign off from the internet, shutdown your computer and rest easy knowing your bid will be placed at the last possible second.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card services-box">
                        <div class="card-body p-4">
                            <div class="services-icon mb-3">
                                <i class="pe-7s-headphones h3 mt-0"></i>
                            </div>
                            <h4 class="mb-3">Fast Support (Always human)</h4>
                            <p class="text-justify">Sometimes the world of auction sniping is not clear and that is why we offer email support to our users. Our current policy is to reply to your email within 12 hours ( Usually much, much faster ) and if the problem can't be solved then we contact you via the telephone if possible.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card services-box">
                        <div class="card-body p-4">
                            <div class="services-icon mb-3">
                                <i class="pe-7s-science h3 mt-0"></i>
                            </div>
                            <h4 class="mb-3">Auction Outcome Notification</h4>
                            <p class="text-justify">In order to assist you and make your life easier, we send you the outcome of your sniped auction. With detailed info provided within each email, you will always know what the status of your bid was.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card services-box">
                        <div class="card-body p-4">
                            <div class="services-icon mb-3">
                                <i class="pe-7s-exapnd2 h3 mt-0"></i>
                            </div>
                            <h4 class="mb-3">Sign up (Free)</h4>
                            <p>Because we believe everyone should be able to use our service, we do not charge sign up. All you have to do is visit our Sign Up page to get started.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card services-box">
                        <div class="card-body p-4">
                            <div class="services-icon mb-3">
                                <i class="pe-7s-phone h3 mt-0"></i>
                            </div>
                            <h4 class="mb-3">Works with ALL devices and browsers (Responsive Layouts)</h4>
                            <p class="text-justify">Since all of the information is on our website and there is nothing to download, you can use our service to snipe from any computer, or mobile device.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section pb-lg-0" id="contact">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="title text-center mb-4">
                        <h5 class="text-primary small-title">Contact</h5>
                        <h3>{{ config('app.name', 'Laravel') }}</h3>
                        <p>Contact me if you want to ask something about {{ config('app.name', 'Laravel') }}.</p>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <div class="col-lg-6">
                    <div class="contact-img d-none d-lg-block">
                        <img src="{{ asset('images/contact-us.svg') }}" alt="" class="img-fluid mx-auto d-block">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card contact-form mb-lg-0">
                        <div class="custom-form p-5">
                            @if(session()->has('message'))
                                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            <form method="post" action="/contact" name="contact-form" id="contact-form">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="name" id="name" type="text" class="form-control" placeholder="Enter your name..." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="email" id="email" type="email" class="form-control" placeholder="Enter your email..." required>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <textarea name="comments" id="comments" rows="4" class="form-control" placeholder="Enter your message..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary btn-rounded" value="Send Message">
                                        <div id="simple-msg"></div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </form>
                        </div>
                        <!-- end custom-form -->

                    </div>
                </div>

            </div>
            <!-- row end -->
        </div>
        <!-- container-fluid end -->
    </section>

    <footer class="footer">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="50">
                        <p class="text-white">We make People happy!</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="pt-1">
                        <div class="float-left mr-2">
                            <i class="pe-7s-phone h4 text-white"></i>
                        </div>
                        <p class="text-white-50 overflow-hidden">(123) 456-7890</p>
                    </div>
                    <div>
                        <div class="float-left mr-2">
                            <i class="pe-7s-mail h4 text-white"></i>
                        </div>
                        <p class="text-white-50 overflow-hidden mb-0">{{ 'info@' . str_replace('http://', '', config('app.url', 'localhost')) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div class="footer-alt py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0">{{ date('Y') }} &copy; {{ config('app.name', 'Laravel') }}. | Made with ❤ | Theme by Coderthemes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
