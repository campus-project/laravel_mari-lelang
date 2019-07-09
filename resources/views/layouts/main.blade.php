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
                        heading: 'Oh snap!',
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
                    heading: 'Oh snap!',
                    text: errors,
                    position: 'bottom-right',
                    loaderBg: '#bf441d',
                    icon: 'error'
                });
            }
        }
    </script>
@endsection
