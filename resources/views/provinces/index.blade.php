@extends('layouts.main')

@section('title', 'Province')

@section('main')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="page-title-alt-bg"></div>
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">Province</li>
                    </ol>
                </div>
                <h4 class="page-title">Province Master</h4>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary waves-effect waves-light" onclick="handlerCreate()">Create</button>
                        </div>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-default" class="parsley">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Setup Province</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter province name" parsley-trigger="change" required>
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

@section('vendorCss')
    <!-- third party css -->
    <link href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
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
@endsection

@section('additionalJs')
    <script>
        $(document).ready(function(){
            $(".parsley").parsley()
        });

        const formDefault = $('#form-default');

        const table = $("#datatable").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searchDelay: 300,
            ajax: '/datatable/province',
            columns: [
                {data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false },
                {data: 'name', name: 'name' },
                {data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        function handlerClose() {
            NProgress.start();
            $('#modal-default').modal('hide');
            formDefault.trigger('reset');
            NProgress.done();
        }

        function handlerCreate() {
            NProgress.start();
            $('#state').val('create');
            $('#save-button').prop('disabled', false);
            $('#modal-default').modal('show');
            NProgress.done();
        }

        function handlerUpdate(id) {
            NProgress.start();
            $('#state').val(id);
            axios.get(`/province/${id}`)
                .then((resp) => {
                    $('#name').val(resp.data.data.name);
                    $('#save-button').prop('disabled', !resp.data.data.can_update);
                    $('#modal-default').modal('show');
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
                    await axios.delete('/province/' + id)
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
            const form = $(this);
            form.parsley().validate();
            if (!form.parsley().isValid()) {
                return false
            }

            NProgress.start();
            const state = $('#state').val();
            const formData = {
                name: $('#name').val()
            };
            const data = {
                url: state === 'create' ? '/province' : '/province/' + state,
                method: state === 'create' ? 'post' : 'put',
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
                        notifyError(rej.response.data.message);
                    }
                });

            NProgress.done();
        })
    </script>
@endsection
