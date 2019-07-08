@extends('layouts.app')

@section('content')
    @include('layouts.top-nav')

    @yield('main')

    @include('layouts.footer')
@endsection

@section('helperJs')
    <script>
        const axiosConfig = {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        };

        function notifyError(errors) {
            if (Array.isArray(errors)) {
                setTimeout(() => {
                    $.toast({
                        text: errors[0],
                        icon: 'error',
                        loader: true
                    });
                }, 200)
            } else if (typeof errors === 'object') {
                Object.keys(errors).forEach((key) => {
                    this.notifyError(errors[key]);
                })
            } else {
                $.toast({
                    text: errors,
                    icon: 'error',
                    loader: true
                });
            }
        }
    </script>
@endsection