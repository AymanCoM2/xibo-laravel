<!doctype html>
<html lang="en">

@include('layouts.dashboard-parts.head-tag')

<body>
    <!-- Page Container -->
    <div id="page-container"
        class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed page-header-dark main-content-boxed">

        <!-- Sidebar -->
        @include('layouts.dashboard-parts.side-bar')
        <!-- END Sidebar -->
        <!-- Header -->
        @include('layouts.dashboard-parts.header')
        <!-- END Header -->

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="content">
                @yield('content')
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->

    @include('layouts.dashboard-parts.scripts')
</body>

</html>
