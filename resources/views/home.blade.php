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
                <h4 class="page-title">Starter Page</h4>
            </div>
        </div>
    </div>
@endsection
