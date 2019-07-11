<header id="topnav">
    <!-- Topbar Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                <li class="dropdown notification-list">
                    <a class="navbar-toggle nav-link">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ Auth::user()->photo_url ? asset('images/users/' . Auth::user()->photo_url) : asset('images/default_profile.jpg')  }}" alt="user-image" class="rounded-circle">
                        <span class="pro-user-name ml-1">
                                    {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                                </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <div class="dropdown-item noti-title">
                            <h6 class="m-0">Welcome !</h6>
                        </div>

                        <a href="{{ route('profile') }}" class="dropdown-item notify-item">
                            <i class="dripicons-user"></i> <span>My Account</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <a href="javascript:void(0);" class="dropdown-item notify-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="dripicons-power"></i> <span>Logout</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </li>
            </ul>

            <ul class="list-unstyled menu-left mb-0">
                <li class="float-left logo-box">
                    <a href="{{ route('home') }}" class="logo">
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="45">
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="topbar-menu">
        <div class="container-fluid">
            <div id="navigation">
                <ul class="navigation-menu">
                    <li class="has-submenu">
                        <a href="{{ route('home') }}">
                            <i class="dripicons-home"></i> Home
                        </a>
                    </li>

                    <li class="has-submenu">
                        <a href="{{ route('auction-product.index') }}">
                            <i class="dripicons-inbox"></i> Product
                        </a>
                    </li>

                    <li class="has-submenu">
                        <a href="{{ route('auction-product.index') }}">
                            <i class="dripicons-device-desktop"></i> Room
                        </a>
                    </li>

                    <li class="has-submenu">
                        <a href="#">
                            <i class=" dripicons-document"></i> Master Data <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li>
                                        <a href="{{ route('province.index') }}">Province</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('city.index') }}">City</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product-type.index') }}">Product Type</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</header>
