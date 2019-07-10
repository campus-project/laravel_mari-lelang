@extends('layouts.main')

@section('title', 'Home')

@section('main')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="page-title-alt-bg"></div>
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Starter Page</h4>
            </div>

            <div class="row">
                <div class="col-xl-3">
                    <div class="card-box gradient-success bx-shadow-lg">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0);" class="dropdown-item">Top up</a>
                                <a href="javascript:void(0);" class="dropdown-item">Withdrawal</a>
                            </div>
                        </div>
                        <h4 class="header-title text-white">My Wallets</h4>
                        <div class="my-4">
                            <h2 class="font-weight-normal text-white mb-2">IDR {{ number_format(Auth::user()->wallet_balance) }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card-box">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Download</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Upload</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                        <h4 class="header-title mb-4">Transaction History</h4>

                        <div class="table-responsive">
                            <table class="table table-centered table-hover mb-0" id="datatable">
                                <thead>
                                <tr>
                                    <th class="border-top-0">Name</th>
                                    <th class="border-top-0">Card</th>
                                    <th class="border-top-0">Date</th>
                                    <th class="border-top-0">Amount</th>
                                    <th class="border-top-0">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <img src="assets/images/users/avatar-2.jpg" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
                                        <span class="ml-2">Imelda J. Stanberry</span>
                                    </td>
                                    <td>
                                        <img src="assets/images/cards/visa.png" alt="user-card" height="24" />
                                        <span class="ml-2">**** 3256</span>
                                    </td>
                                    <td>27.03.2018</td>
                                    <td>$345.98</td>
                                    <td><span class="badge badge-pill badge-danger">Failed</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="assets/images/users/avatar-3.jpg" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
                                        <span class="ml-2">Francisca S. Lobb</span>
                                    </td>
                                    <td>
                                        <img src="assets/images/cards/master.png" alt="user-card" height="24" />
                                        <span class="ml-2">**** 8451</span>
                                    </td>
                                    <td>28.03.2018</td>
                                    <td>$1,250</td>
                                    <td><span class="badge badge-pill badge-success">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="assets/images/users/avatar-1.jpg" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
                                        <span class="ml-2">James A. Wert</span>
                                    </td>
                                    <td>
                                        <img src="assets/images/cards/amazon.png" alt="user-card" height="24" />
                                        <span class="ml-2">**** 2258</span>
                                    </td>
                                    <td>28.03.2018</td>
                                    <td>$145</td>
                                    <td><span class="badge badge-pill badge-success">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="assets/images/users/avatar-4.jpg" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
                                        <span class="ml-2">Dolores J. Pooley</span>
                                    </td>
                                    <td>
                                        <img src="assets/images/cards/american-express.png" alt="user-card" height="24" />
                                        <span class="ml-2">**** 6950</span>
                                    </td>
                                    <td>29.03.2018</td>
                                    <td>$2,005.89</td>
                                    <td><span class="badge badge-pill badge-danger">Failed</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="assets/images/users/avatar-5.jpg" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
                                        <span class="ml-2">Karen I. McCluskey</span>
                                    </td>
                                    <td>
                                        <img src="assets/images/cards/discover.png" alt="user-card" height="24" />
                                        <span class="ml-2">**** 0021</span>
                                    </td>
                                    <td>31.03.2018</td>
                                    <td>$24.95</td>
                                    <td><span class="badge badge-pill badge-success">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="assets/images/users/avatar-6.jpg" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
                                        <span class="ml-2">Kenneth J. Melendez</span>
                                    </td>
                                    <td>
                                        <img src="assets/images/cards/visa.png" alt="user-card" height="24" />
                                        <span class="ml-2">**** 2840</span>
                                    </td>
                                    <td>27.03.2018</td>
                                    <td>$345.98</td>
                                    <td><span class="badge badge-pill badge-success">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="assets/images/users/avatar-7.jpg" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
                                        <span class="ml-2">Sandra M. Nicholas</span>
                                    </td>
                                    <td>
                                        <img src="assets/images/cards/master.png" alt="user-card" height="24" />
                                        <span class="ml-2">**** 2015</span>
                                    </td>
                                    <td>28.03.2018</td>
                                    <td>$1,250</td>
                                    <td><span class="badge badge-pill badge-danger">Failed</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="assets/images/users/avatar-8.jpg" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
                                        <span class="ml-2">Ronald S. Taylor</span>
                                    </td>
                                    <td>
                                        <img src="assets/images/cards/amazon.png" alt="user-card" height="24" />
                                        <span class="ml-2">**** 0325</span>
                                    </td>
                                    <td>28.03.2018</td>
                                    <td>$145</td>
                                    <td><span class="badge badge-pill badge-success">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="assets/images/users/avatar-9.jpg" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
                                        <span class="ml-2">Beatrice L. Iacovelli</span>
                                    </td>
                                    <td>
                                        <img src="assets/images/cards/discover.png" alt="user-card" height="24" />
                                        <span class="ml-2">**** 9058</span>
                                    </td>
                                    <td>29.03.2018</td>
                                    <td>$6,542.32</td>
                                    <td><span class="badge badge-pill badge-success">Paid</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="assets/images/users/avatar-10.jpg" alt="user-pic" class="rounded-circle avatar-sm bx-shadow-lg" />
                                        <span class="ml-2">Sylvia H. Parker</span>
                                    </td>
                                    <td>
                                        <img src="assets/images/cards/discover.png" alt="user-card" height="24" />
                                        <span class="ml-2">**** 2577</span>
                                    </td>
                                    <td>31.03.2018</td>
                                    <td>$24.95</td>
                                    <td><span class="badge badge-pill badge-danger">Failed</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalJs')
    <script>
        $(document).ready(function() {
            $('#datatable').dataTable()
        })
    </script>
@endsection