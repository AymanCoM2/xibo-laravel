<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header (mini Sidebar mode) -->
    <div class="smini-visible-block">
        <div class="content-header bg-primary">
            <!-- Logo -->
            <a class="fw-semibold text-white tracking-wide" href="index.html">
                D<span class="opacity-75">x</span>
            </a>
            <!-- END Logo -->
        </div>
    </div>
    <!-- END Side Header (mini Sidebar mode) -->

    <!-- Side Header (normal Sidebar mode) -->
    <div class="smini-hidden">
        <div class="content-header justify-content-lg-center bg-primary">
            <!-- Logo -->
            <a class="fw-semibold text-white tracking-wide" href="{{ route('home-page') }}">
                Chaya<span class="opacity-75">Chips</span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div class="d-lg-none">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout"
                    data-action="sidebar_close">
                    <i class="fa fa-times-circle"></i>
                </button>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
    </div>
    <!-- END Side Header (normal Sidebar mode) -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- User Info -->
        <div class="smini-hidden">
            <div class="content-side content-side-full bg-black-10 d-flex align-items-center">
                <a class="img-link d-inline-block" href="javascript:void(0)">
                    <img class="img-avatar img-avatar48 img-avatar-thumb" src="https://avatar.iran.liara.run/public"
                        alt="">
                </a>
                <div class="ms-3">
                    <a class="fw-semibold text-dual" href="javascript:void(0)">Admin user Name</a>
                    <div class="fs-sm text-dual">Sub title</div>
                </div>
            </div>
        </div>
        <!-- END User Info -->

        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-heading">Stores</li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('create-store') }}">
                        <i class="nav-main-link-icon fa fa-plus"></i>
                        <span class="nav-main-link-name">New Store</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('manage-stores') }}">
                        <i class="nav-main-link-icon fa fa-store"></i>
                        <span class="nav-main-link-name">Manage Stores</span>
                    </a>
                </li>
                <hr>
                <li class="nav-main-heading">Products</li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('create-product') }}">
                        <i class="nav-main-link-icon fa fa-plus"></i>
                        <span class="nav-main-link-name">New Product</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('manage-products') }}">
                        <i class="nav-main-link-icon fa-product-hunt"></i>
                        <span class="nav-main-link-name">Manage Products</span>
                    </a>
                </li>


                <hr>
                <li class="nav-main-heading">Displays</li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('get-displays') }}">
                        <i class="nav-main-link-icon fa-product-hunt"></i>
                        <span class="nav-main-link-name">Manage Displays</span>
                    </a>
                </li>

                <li class="nav-main-heading">Dashboards</li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="#">
                        <i class="nav-main-link-icon fa fa-key"></i>
                        <span class="nav-main-link-name">Credentials</span>
                    </a>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link" href="#">
                        <i class="nav-main-link-icon fa fa-arrow-left"></i>
                        <span class="nav-main-link-name">Log Out</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
