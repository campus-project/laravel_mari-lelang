<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Vendor Style -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/nprogress/nprogress.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/jquery-toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .dz-image img {
            width: 125px;
            height: 125px;
        }
    </style>
@yield('vendorCss')

    <!-- Styles -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Additional Css -->
    <style>
        .loading-indicator:before {
            content: '';
            background: #000000cc;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .loading-indicator:after {
            content: 'Loading';
            position: fixed;
            width: 100%;
            top: 50%;
            left: 0;
            z-index: 1001;
            color:white;
            text-align:center;
            font-weight:bold;
            font-size:1.5rem;
        }

        .modal {
            overflow-y:auto;
        }
    </style>

    @yield('additionalCss')
</head>
<body class="@yield('bodyClass')">
@yield('content')

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/libs/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-toast/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/libs/axios/axios.min.js') }}"></script>
@yield('vendorJs')

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

@yield('helperJs')
    <!-- Additional Js -->
@yield('additionalJs')
</body>
</html>
