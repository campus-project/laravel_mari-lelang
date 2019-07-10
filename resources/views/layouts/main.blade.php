@extends('layouts.app')

@section('content')
    @include('layouts.top-nav')

    @yield('main')

    @include('layouts.footer')
@endsection

@section('vendorCss')
    <!-- third party css -->
    <link href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('vendorJs')
    <!-- datatable js -->
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.print.min.js') }}"></script>

    <script src="{{ asset('assets/libs/datatables/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-inputmask/jquery.inputmask.min.js') }}"></script>
@endsection

@section('helperJs')
    <script>
        const axiosConfig = {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        };

        function notifyError(errors, title = 'Oh snap!') {
            if (Array.isArray(errors)) {
                setTimeout(() => {
                    $.toast({
                        heading: title,
                        text: errors[0],
                        position: 'bottom-right',
                        loaderBg: '#bf441d',
                        icon: 'error'
                    });
                }, 200)
            } else if (typeof errors === 'object') {
                Object.keys(errors).forEach((key) => {
                    this.notifyError(errors[key]);
                })
            } else {
                $.toast({
                    heading: title,
                    text: errors,
                    position: 'bottom-right',
                    loaderBg: '#bf441d',
                    icon: 'error'
                });
            }
        }
    </script>
@endsection
