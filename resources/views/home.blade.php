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

            @if(count($auctionLimited30Minutes))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <h4 class="header-title">Limited Offer (30 Minutes)</h4>
                            <p class="sub-header"></p>
                            <div id="demo" class="carousel slide" data-ride="carousel" data-interval="2000">
                                <div class="carousel-inner">
                                    @foreach($auctionLimited30Minutes as $index => $auctionLimited30Minute)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : ''}}">
                                            <div class="row">
                                                @foreach($auctionLimited30Minute as $product)
                                                    <div class="col-md-3">
                                                        <div class="card border border-primary">
                                                            <img class="card-img-top img-fluid" src="{{ $product['auction_product_photos'][0]['photo_url'] }}" alt="{{ $product['name'] }}">
                                                            <div class="card-body">
                                                                <h5 class="card-title max-text">{{ $product['name'] }}</h5>
                                                                <div class="row">
                                                                    <div class="col-md-6 p-1">
                                                                        <button type="button" class="btn btn-primary waves-effect waves-light btn-block" onclick="bid({{ $product['id'] }})">BID</button>
                                                                    </div>

                                                                    <div class="col-md-6 p-1">
                                                                        <a href="{{ route('auction-product.show', ['id' => $product['id']]) }}" class="btn btn-secondary waves-effect waves-light btn-block">View</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#demo" data-slide="prev" style="width: 5%">
                                    <span class="carousel-control-prev-icon"></span>
                                </a>
                                <a class="carousel-control-next" href="#demo" data-slide="next" style="width: 5%">
                                    <span class="carousel-control-next-icon"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(count($auctionProducts))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <h4 class="header-title">Newest</h4>
                            <p class="sub-header"></p>
                            <div id="demo" class="carousel slide" data-ride="carousel" data-interval="2000">
                                <div class="carousel-inner">
                                    @foreach($auctionProducts as $index => $auction)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : ''}}">
                                            <div class="row">
                                                @foreach($auction as $product)
                                                    <div class="col-md-3">
                                                        <div class="card border border-primary">
                                                            <img class="card-img-top img-fluid" src="{{ $product['auction_product_photos'][0]['photo_url'] }}" alt="{{ $product['name'] }}">
                                                            <div class="card-body">
                                                                <h5 class="card-title max-text">{{ $product['name'] }}</h5>
                                                                <div class="row">
                                                                    <div class="col-md-6 p-1">
                                                                        <button type="button" class="btn btn-primary waves-effect waves-light btn-block" onclick="bid({{ $product['id'] }})">BID</button>
                                                                    </div>

                                                                    <div class="col-md-6 p-1">
                                                                        <a href="{{ route('auction-product.show', ['id' => $product['id']]) }}" class="btn btn-secondary waves-effect waves-light btn-block">View</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#demo" data-slide="prev" style="width: 5%">
                                    <span class="carousel-control-prev-icon"></span>
                                </a>
                                <a class="carousel-control-next" href="#demo" data-slide="next" style="width: 5%">
                                    <span class="carousel-control-next-icon"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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