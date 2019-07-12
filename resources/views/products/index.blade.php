@php($name = 'Product')

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
                        <table id="datatable" class="table table-striped dt-responsive nowrap">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Photo</th>
                                <td>Type</td>
                                <th>City</th>
                                <th>Province</th>
                                <td>Seller</td>
                                <td>Action</td>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalJs')
    <script>
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
                {data: 'name', name: 'name' },
                {data: 'photo', name: 'Photo', orderable: false, searchable: false },
                {data: 'product_type', name: 'productType.name' },
                {data: 'city', name: 'city.name' },
                {data: 'province', name: 'city.province.name' },
                {data: 'created_by', name: 'createdBy.name'},
                {data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    </script>
@endsection
