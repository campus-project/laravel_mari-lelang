@extends('layouts.main')

@section('title', 'Home')

@section('main')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="page-title-alt-bg"></div>
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Home</h4>
            </div>

            <div class="row">
                <div class="col-xl-3">
                    <div class="card-box gradient-success bx-shadow-lg">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0);" class="dropdown-item">Top up</a>
                                <a href="javascript:void(0);" class="dropdown-item">Withdrawal</a>
                            </div>
                        </div>
                        <h4 class="header-title text-white">My Wallets</h4>
                        <div class="my-4">
                            <h2 class="font-weight-normal text-white mb-2">IDR {{ number_format(Auth::user()->wallet_balance) }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="demo" class="carousel slide" data-ride="carousel" data-interval="2000">
                        <ul class="carousel-indicators" style="z-index:1">
                            <li data-target="#demo" data-slide-to="0" class="active"></li>
                            <li data-target="#demo" data-slide-to="1"></li>
                            <li data-target="#demo" data-slide-to="2"></li>
                        </ul>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 1</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 2</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 3</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 4</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 5</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 6</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 7</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 8</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 9</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 10</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 11</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">Card title 12</h5>
                                                <a href="#" class="btn btn-primary waves-effect waves-light">Button</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#demo" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#demo" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalJs')
    <script>
        $(document).ready(function() {
            $('#datatable').dataTable()
        })
    </script>
@endsection