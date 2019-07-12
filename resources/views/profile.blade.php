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
                                <img class="card-img-top img-fluid" src="{{ Auth::user()->photo_url ? asset('images/users/' . Auth::user()->photo_url) : asset('images/default_profile.jpg')  }}" alt="user-image" height="20px">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Auth::user()->name }} ({{ Auth::user()->is_admin ? 'Administrator' : 'User' }})</h5>
                                    <p class="card-text">Membership at : {{ Auth::user()->membership }}</p>
                                    <p class="card-text"><i class="icon-location-pin"></i> {{ Auth::user()->city->name }}</p>

                                    <div class="row">
                                        <div class="col-md-6 p-1">
                                            <button type="button" class="btn btn-primary btn-block" onclick="handlerUpdate()">Edit Profile</button>
                                        </div>
                                        <div class="col-md-6 p-1">
                                            <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modal-password">Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box gradient-success bx-shadow-lg">
                                <div class="dropdown float-right">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="javascript:void(0);" id="topup" class="dropdown-item">Top up</a>
                                        <a href="javascript:void(0);" id="topup_verification" class="dropdown-item">Top up Verification</a>
                                        <a href="javascript:void(0);" id="withdrawal" class="dropdown-item">Withdrawal</a>
                                    </div>
                                </div>
                                <h4 class="header-title text-white">My Wallets</h4>
                                <div class="my-4">
                                    <h2 class="font-weight-normal text-white mb-2">IDR {{ number_format(Auth::user()->wallet_balance, 2) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-xl-6">
                    <div class="card-box">
                        <h4 class="header-title mb-4">Transaction History</h4>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-centered table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-default" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form-default">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Update Profile</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter product name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="province">Province</label>
                                <select id="province" class="form-control" required style="width:100%"></select>
                            </div>

                            <div class="col-md-6">
                                <label for="city">City</label>
                                <select id="city" class="form-control" required style="width:100%"></select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 p-2">
                                <label for="photo">Photos</label>
                                <div id="photos" class="dropzone">
                                    <div class="dz-message needsclick">
                                        <i class="h1 text-muted dripicons-cloud-upload"></i>
                                        <h3>Drop files here or click to upload.</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="state" value="create">
                        <button type="button" class="btn btn-light waves-effect" onclick="handlerClose()">Close</button>
                        <button type="submit" id="save-button" class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-password" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-password">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Update Password</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="old_password">Old Password</label>
                                    <input type="password" class="form-control" id="old_password" placeholder="Enter old password" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter new password" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" placeholder="Enter confirm confirm" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" onclick="handlerPasswordClose()">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>
                </form>
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
