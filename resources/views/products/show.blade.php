@extends('layouts.main')

@section('title', 'Profile')

@section('main')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="page-title-alt-bg"></div>
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">Profile</h4>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-4 col-xl-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <img class="card-img-top img-fluid" src="/{{ $photos[0][0]['photo_url'] }}" alt="{{ $product->name }}" height="20px">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">Membership at : {{ Auth::user()->membership }}</p>
                                    <p class="card-text"><i class="icon-location-pin"></i> {{ Auth::user()->city->name }}</p>

                                    <div class="row">
                                        <div class="col-md-6 p-1">
                                            <button type="button" class="btn btn-primary waves-effect waves-light btn-block" onclick="bid({{ $product->id }})">BID</button>
                                        </div>

                                        <div class="col-md-6 p-1">
                                            <a href="{{ route('product.index') }}" class="btn btn-secondary waves-effect waves-light btn-block">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-xl-6">
                    <div class="card-box">
                        <p class="sub-header"></p>
                        <div id="demo" class="carousel slide" data-ride="carousel" data-interval="2000">
                            <div class="carousel-inner">
                                @foreach($photos as $index => $p)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : ''}}">
                                        <div class="row">
                                            @foreach($p as $a)
                                                <div class="col-md-4">
                                                    <div class="card border border-primary">
                                                        <img class="card-img-top img-fluid" src="/{{ $a['photo_url'] }}" alt="{{ $product->name }}">
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
                        <p>{{ $product->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalJs')
    <script>
        const formDefault = $('#form-default');
        const formPassword = $('#form-password');
        const modalDefault = $('#modal-default');
        const modalPassword = $('#modal-password');
        const model = {
            name: $('#name'),
            email: $('#email'),
            phone: $('#phone'),
            address: $('#address'),
            account_number: $('#account_number'),
            province: $('#province'),
            city: $('#city'),
            old_password: $('#old_password'),
            password: $('#password'),
            confirm_password: $('#confirm_password'),
        };

        Dropzone.autoDiscover = false;

        $(document).ready(function(){
            model.province.select2({
                placeholder: "Select Province",
                dropdownParent: formDefault,
                ajax: {
                    url: '{{ route('province.select') }}',
                    dataType: 'json',
                    type: 'get',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            per_page: 20,
                            page: params.page || 1
                        }
                    },
                    processResults: function (resp) {
                        return {
                            results: resp.data,
                            pagination: {
                                more: resp.meta.current_page < resp.meta.last_page
                            }
                        };
                    }
                }
            });

            model.city.select2({
                placeholder: "Select City",
                dropdownParent: formDefault,
                ajax: {
                    url: '{{ route('city.select') }}',
                    dataType: 'json',
                    type: 'get',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            per_page: 20,
                            page: params.page || 1,
                            province: model.province.val()
                        }
                    },
                    processResults: function (resp) {
                        return {
                            results: resp.data,
                            pagination: {
                                more: resp.meta.current_page < resp.meta.last_page
                            }
                        };
                    }
                }
            });
        });

        var currentFile = null;
        var mock = null;
        $('#photos').dropzone({
            url: 'profile',
            addRemoveLinks: true,
            maxFilesize: 1,
            maxFiles: 1,
            dictFileTooBig: 'Image is larger than 1MB',
            autoQueue: false,
            acceptedFiles: 'image/*,.png,.jpg,.jpeg,.gif',
            init: function (){
                this.on("addedfile", function(file) {
                    if (mock) {
                        this.removeFile(mock);
                    }

                    if (currentFile) {
                        this.removeFile(currentFile);
                    }
                    currentFile = file;
                });
            }
        });

        model.province.change(function() {
            model.city.val('').trigger('change');
        });

        const table = $("#datatable").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searchDelay: 300,
            ajax: '{{ route('transaction.datatable') }}',
            columns: [
                { data: 'date', name: 'date' },
                { data: 'name', name: 'name' },
                { data: 'amount', name: 'amount' },
                { data: 'status', name: 'status' }
            ]
        });

        modalDefault.on('hidden.bs.modal', function () {
            handlerClose()
        });

        function handlerPasswordClose() {
            modalPassword.modal('hide');
            formPassword.trigger('reset')
        }

        formPassword.on('submit', function(e) {
            e.preventDefault();
            NProgress.start();
            const data = {
                url: '{{ route('user.update-password') }}',
                method: 'post',
                data: {
                    old_password: model.old_password.val(),
                    password: model.password.val(),
                    password_confirmation: model.confirm_password.val()
                },
                config: axiosConfig
            };

            axios(data)
                .then((resp) => {
                    $.toast({
                        text: resp.data.message,
                        icon: 'success',
                        loader: true
                    });

                    handlerClose();
                    setTimeout(() => {
                        location.reload()
                    }, 1000)
                })
                .catch((rej) => {
                    if (rej && rej.response) {
                        notifyError(rej.response.data.errors, rej.response.data.message);
                    }
                });
        });

        function handlerClose() {
            modalDefault.modal('hide');
            formDefault.trigger('reset');
            model.province.val('').trigger('change');
            model.city.val('').trigger('change');
            Dropzone.forElement('#photos').removeAllFiles(true);
            $('#save-button').prop('disabled', false);
        }

        async function handlerUpdate() {
            NProgress.start();
            await axios.get('/user/{{ Auth::user()->id }}')
                .then(async (resp) => {
                    model.name.val(resp.data.data.name);
                    model.email.val(resp.data.data.email);
                    model.phone.val(resp.data.data.phone);
                    model.address.val(resp.data.data.address);
                    model.account_number.val(resp.data.data.account_number);
                    model.province.append(new Option(resp.data.data.city.province.name, resp.data.data.city.province.id, true, true)).trigger('change');
                    model.city.append(new Option(resp.data.data.city.name, resp.data.data.city.id, true, true)).trigger('change');
                    if (resp.data.data.photo.name) {
                        $(function() {
                            const mockFile = { name: resp.data.data.photo.name, size: resp.data.data.photo.size, type: resp.data.data.photo.type };
                            const myDropzone = Dropzone.forElement('#photos');
                            myDropzone.options.addedfile.call(myDropzone, mockFile);
                            myDropzone.options.thumbnail.call(myDropzone, mockFile, resp.data.data.photo.base64);
                            myDropzone.files.push(mockFile);
                            mockFile.previewElement.classList.add('dz-success');
                            mockFile.previewElement.classList.add('dz-complete');
                            mock = mockFile
                        });
                    }
                    modalDefault.modal('show');
                })
                .catch((rej) => {
                    if (rej && rej.response) {
                        notifyError(rej.response.data.message);
                    }
                });
            NProgress.done();
        }

        formDefault.on('submit', function(e) {
            e.preventDefault();
            let count = 0;
            NProgress.start();
            const state = $('#state').val();
            const formData = new FormData();
            formData.append('name', model.name.val());
            formData.append('city_id', model.city.val());
            formData.append('_method', 'PUT');
            formData.append('address', model.address.val());
            const photo = Dropzone.forElement('#photos').getAcceptedFiles();

            if (photo.length > 0) {
                formData.append('photo', photo[0]);
            } else {
                if (Dropzone.forElement('#photos').files.length > 0 && !Dropzone.forElement('#photos').files[0].status) {
                    formData.append('photo', mock.name);
                }

            }

            const data = {
                url: '/user/{{ Auth::user()->id }}',
                method: 'post',
                data: formData,
                config: axiosConfig
            };

            axios(data)
                .then((resp) => {
                    $.toast({
                        text: resp.data.message,
                        icon: 'success',
                        loader: true
                    });

                    handlerClose();
                    setTimeout(() => {
                        location.reload()
                    }, 1000)
                })
                .catch((rej) => {
                    if (rej && rej.response) {
                        notifyError(rej.response.data.errors, rej.response.data.message);
                    }
                });

            NProgress.done();
        })
    </script>
@endsection
