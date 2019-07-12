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
    <link href="{{ asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .max-text {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: inherit;
        }
    </style>
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
    <script src="{{ asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/moment/moment.min.js') }}"></script>

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

        $('#topup').on('click', function() {
            Swal.fire({
                title: "Enter Amount",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: !0,
                confirmButtonText: "Process",
                confirmButtonColor: "#188ae2",
                cancelButtonColor: "#f34943",
                showLoaderOnConfirm: !0,
                preConfirm: function(value) {
                    const data = {
                        url: "{{ route('topup.store') }}",
                        method: "post",
                        data: {
                            amount: value
                        },
                        config: axiosConfig
                    };

                    return axios(data)
                        .then((resp) => {
                            return resp.data.data
                        }).catch((rej) => {
                            Swal.showValidationMessage("Request failed: " + rej.response.data.message);
                            if (rej && rej.response) {
                                notifyError(rej.response.data.errors, rej.response.data.message);
                            }
                        })
                },
                allowOutsideClick: function() {
                    Swal.isLoading()
                }
            }).then((resp) => {
                if (!resp.dismiss) {
                    Swal.fire({
                        title: "Your topup request has success saved.",
                        text: "Please transfer to BCA: 7640944816, and upload your slip transfer in menu topup.",
                        type: "success",
                        confirmButtonColor: "#188ae2"
                    }).then(() => {
                        location.reload()
                    });
                }
            })
        });

        $('#topup_verification').on('click', function() {
            Swal.fire({
                title: "Select a file",
                input: "file",
                showCancelButton: !0,
                confirmButtonText: "Upload",
                confirmButtonColor: "#188ae2",
                cancelButtonColor: "#f34943",
                showLoaderOnConfirm: !0,
                preConfirm: function(value) {
                    const formData = new FormData;
                    formData.append('photo', value);
                    const data = {
                        url: "{{ route('topup.verification') }}",
                        method: "post",
                        data: formData,
                        config: axiosConfig
                    };

                    return axios(data)
                        .then((resp) => {
                            return resp.data.data
                        }).catch((rej) => {
                            Swal.showValidationMessage("Request failed: " + rej.response.data.message);
                            if (rej && rej.response) {
                                notifyError(rej.response.data.errors, rej.response.data.message);
                            }
                        })
                },
                allowOutsideClick: function() {
                    Swal.isLoading()
                }
            }).then((resp) => {
                if (!resp.dismiss) {
                    Swal.fire({
                        title: "Your slip transfer is being verification",
                        type: "success",
                        confirmButtonColor: "#188ae2"
                    }).then(() => {
                        location.reload()
                    });
                }
            })
        });

        $('#withdrawal').on('click', function() {
            Swal.fire({
                title: "Enter Amount \n Your available: {{ number_format(Auth::user()->wallet_balance, 2) }}",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: !0,
                confirmButtonText: "Process",
                confirmButtonColor: "#188ae2",
                cancelButtonColor: "#f34943",
                showLoaderOnConfirm: !0,
                preConfirm: function(value) {
                    const data = {
                        url: "{{ route('withdrawal.store') }}",
                        method: "post",
                        data: {
                            amount: value
                        },
                        config: axiosConfig
                    };

                    return axios(data)
                        .then((resp) => {
                            return resp.data.data
                        }).catch((rej) => {
                            Swal.showValidationMessage("Request failed: " + rej.response.data.message);
                            if (rej && rej.response) {
                                notifyError(rej.response.data.errors, rej.response.data.message);
                            }
                        })
                },
                allowOutsideClick: function() {
                    Swal.isLoading()
                }
            }).then((resp) => {
                if (!resp.dismiss) {
                    Swal.fire({
                        title: "Your withdrawal request has processes.",
                        type: "success",
                        confirmButtonColor: "#188ae2"
                    }).then(() => {
                        location.reload()
                    });
                }
            })
        });

        async function bid(id) {
            let product = null;

            await axios.get('/auction-product/' + id)
                .then(resp => product = resp.data.data);

            Swal.fire({
                title: "Your balance: {{ number_format(Auth::user()->wallet_balance, 2) }} | (IDR:5000/Bid)",
                text: product.name + ' | Last Bid: ' + product.last_bid + ' | Offer: '+ product.offer_number,
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: !0,
                confirmButtonText: "Bid",
                confirmButtonColor: "#188ae2",
                cancelButtonColor: "#f34943",
                showLoaderOnConfirm: !0,
                preConfirm: function(value) {
                    const data = {
                        url: "{{ route('bid.store') }}",
                        method: "post",
                        data: {
                            amount: value,
                            auction_product_id: product.id
                        },
                        config: axiosConfig
                    };

                    return axios(data)
                        .then((resp) => {
                            return resp.data.data
                        }).catch((rej) => {
                            Swal.showValidationMessage("Request failed: " + rej.response.data.message);
                            if (rej && rej.response) {
                                notifyError(rej.response.data.errors, rej.response.data.message);
                            }
                        })
                },
                allowOutsideClick: function() {
                    Swal.isLoading()
                }
            }).then((resp) => {
                if (!resp.dismiss) {
                    Swal.fire({
                        title: "Your withdrawal request has processes.",
                        type: "success",
                        confirmButtonColor: "#188ae2"
                    }).then(() => {
                        location.reload()
                    });
                }
            })
        }
    </script>
@endsection
