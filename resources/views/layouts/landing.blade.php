<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Vendor Style -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">

    <!--Material Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/materialdesignicons.min.css') }}" />

    <!-- pe-7 Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pe-icon-7-stroke.css') }}" />

    <!-- owl carousel css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.transitions.css') }}">

    <!-- Custom  sCss -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
</head>
<body class="@yield('bodyClass')">
    @yield('content')

    <!-- Javascript -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/scrollspy.min.js') }}"></script>

    <!-- owl-carousel -->
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>

    <!-- custom js -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
