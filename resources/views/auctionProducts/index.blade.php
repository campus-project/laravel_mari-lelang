@php($name = 'Auction Product')

@extends('layouts.main')

@section('title', $name)

@section('main')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="page-title-alt-bg"></div>
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">{{ $name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $name }}</h4>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="handlerCreate()">Create</button>
                        </div>

                        <table id="datatable" class="table table-striped dt-responsive nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Province</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
                        <h4 class="modal-title" id="myModalLabel">Setup {{ $name }}</h4>
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="text" id="start_date" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" data-date-autoclose="true" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="text" id="end_date" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" data-date-autoclose="true" autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="offer">Offer Price</label>
                                <input type="text" id="offer" class="form-control" placeholder="Enter offer price" value="0" required>
                            </div>

                            <div class="col-md-6">
                                <label for="product_type">Product Type</label>
                                <select id="product_type" class="form-control" required style="width:100%"></select>
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

                        <div class="row">
                            <div class="col-md-12">
                                <label for="description">Description</label>
                                <div id="description"></div>
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
@endsection

@section('additionalJs')
    <script>
        const formDefault = $('#form-default');
        const modalDefault = $('#modal-default');
        const model = {
            name: $('#name'),
            start_date: $('#start_date'),
            end_date: $('#end_date'),
            offer: $('#offer'),
            product_type: $('#product_type'),
            province: $('#province'),
            city: $('#city'),
            description: $('#description')
        };

        Dropzone.autoDiscover = false;

        $(document).ready(function(){
            model.description.summernote({
                height: 250,
                minHeight: null,
                maxHeight: null,
                focus: !1,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });

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

            model.product_type.select2({
                placeholder: "Select Product Type",
                dropdownParent: formDefault,
                ajax: {
                    url: '{{ route('product-type.select') }}',
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

        $('#photos').dropzone({
            url: 'auction-product-photo',
            addRemoveLinks: true,
            maxFilesize: 1,
            uploadMultiple: true,
            parallelUploads: 1,
            dictFileTooBig: 'Image is larger than 1MB',
            autoQueue: false,
            acceptedFiles: 'image/*,.png,.jpg,.jpeg,.gif'
        });

        model.province.change(function() {
            model.city.val('').trigger('change');
        });

        model.offer.inputmask({
            'alias': 'integer',
            rightAlign: false,
            'groupSeparator': ',',
            'autoGroup': true
        });

        const table = $("#datatable").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searchDelay: 300,
            ajax: '/datatable/{{ preg_replace("/\s/", "-", strtolower($name)) }}',
            columnDefs: [
                { width: '50px', targets: 0 }
            ],
            columns: [
                {data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false },
                {data: 'name', name: 'name' },
                {data: 'photo', name: 'Photo', orderable: false, searchable: false },
                {data: 'province', name: 'province.name' },
                {data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        modalDefault.on('hidden.bs.modal', function () {
            handlerClose()
        });

        function handlerClose() {
            modalDefault.modal('hide');
            formDefault.trigger('reset');
            model.province.val('').trigger('change');
            model.city.val('').trigger('change');
            model.product_type.val('').trigger('change');
            model.description.summernote('code', '');
            model.auction_product_photo_ids = [];
            Dropzone.forElement('#photos').removeAllFiles(true);
            $('#save-button').prop('disabled', false);
        }

        function handlerCreate() {
            NProgress.start();
            $('#state').val('create');
            modalDefault.modal('show');
            NProgress.done();
        }

        async function handlerUpdate(id) {
            NProgress.start();
            $('#state').val(id);
            await axios.get(`/{{ preg_replace("/\s/", "-", strtolower($name)) }}/${id}`)
                .then(async (resp) => {
                    model.name.val(resp.data.data.name);
                    model.start_date.val(moment(resp.data.data.start_date, 'YYYY-MM-DD').format('MM/DD/YYYY'));
                    model.end_date.val(moment(resp.data.data.end_date, 'YYYY-MM-DD').format('MM/DD/YYYY'));
                    model.offer.val(resp.data.data.offer);
                    model.province.append(new Option(resp.data.data.city.province.name, resp.data.data.city.province.id, true, true)).trigger('change');
                    model.city.append(new Option(resp.data.data.city.name, resp.data.data.city.id, true, true)).trigger('change');
                    model.product_type.append(new Option(resp.data.data.product_type.name, resp.data.data.product_type.id, true, true)).trigger('change');
                    model.description.summernote('code', resp.data.data.description);
                    resp.data.data.auction_product_photos.forEach((photo) => {
                        $(function() {
                            const mockFile = { name: photo.name, size: photo.size, type: photo.type };
                            const myDropzone = Dropzone.forElement('#photos');
                            myDropzone.options.addedfile.call(myDropzone, mockFile);
                            myDropzone.options.thumbnail.call(myDropzone, mockFile, photo.base64);
                            myDropzone.files.push(mockFile);
                            mockFile.previewElement.classList.add('dz-success');
                            mockFile.previewElement.classList.add('dz-complete');
                        })
                    });
                    $('#save-button').prop('disabled', !resp.data.data.can_update);
                    modalDefault.modal('show');
                })
                .catch((rej) => {
                    if (rej && rej.response) {
                        notifyError(rej.response.data.message);
                    }
                });
            NProgress.done();
        }

        async function handlerDelete(id) {
            NProgress.start();

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ml-2 mt-2",
                buttonsStyling: !1
            }).then(async function (result) {
                if (result.value) {
                    await axios.delete('/{{ preg_replace("/\s/", "-", strtolower($name)) }}/' + id)
                        .then((resp) => {
                            $.toast({
                                text: resp.data.message,
                                icon: 'success',
                                loader: true
                            });

                            handlerClose();
                            table.ajax.reload();
                        })
                        .catch((rej) => {
                            if (rej && rej.response) {
                                notifyError(rej.response.data.message);
                            }
                        });
                }
            });

            NProgress.done();
        }

        formDefault.on('submit', function(e) {
            e.preventDefault();

            NProgress.start();
            const state = $('#state').val();
            const formData = new FormData();
            formData.append('name', model.name.val());
            formData.append('start_date', moment(model.start_date.val(), 'MM/DD/YYYY').format('YYYY-MM-DD'));
            formData.append('end_date', moment(model.end_date.val(), 'MM/DD/YYYY').format('YYYY-MM-DD'));
            formData.append('offer', model.offer.val().replace(/,/g, ''));
            formData.append('product_type_id', model.product_type.val());
            formData.append('city_id', model.city.val());
            formData.append('description', model.description.summernote('code'));
            Dropzone.forElement('#photos').getAcceptedFiles().forEach((file, index) => {
                formData.append('auction_product_photos['+index+']', file);
            });

            if (state !== 'create') {
                formData.append('_method', 'PUT')
            }

            const data = {
                url: state === 'create' ? '/{{ preg_replace("/\s/", "-", strtolower($name)) }}' : '/{{ preg_replace("/\s/", "-", strtolower($name)) }}/' + state,
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
                    table.ajax.reload();
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
