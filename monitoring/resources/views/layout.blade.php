<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a051b84b57.js" crossorigin="anonymous"></script>

    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.min.js"></script>

    <style>
        body {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>


</head>

{{-- <body class="hold-transition sidebar-mini" oncontextmenu="return false;"> --}}

<body class="hold-transition sidebar-mini position-fixed w-100">
    <div class="wrapper ">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Add your navbar content here -->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">Admin</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add your sidebar content here -->
                        <li class="nav-item">
                            <a id="dashboard-link" href="{{ '/dashboard' }}"
                                class="nav-link {{ Request::url() == url('/dashboard') ? 'active' : '' }}">
                                <i class="fa-solid fa-chart-simple nav-icon"></i>
                                <p>Dashboard</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="unit-owner-link" href="{{ '/unit-owners' }}"
                                class="nav-link {{ Request::url() == url('/unit-owners') ? 'active' : '' }} {{ Request::url() == url('/view_owner_data') ? 'active' : '' }}">
                                <i class="fa-solid fa-users nav-icon"></i>
                                <p>Unit Owner</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a id="accounts-link" href="{{ '/accounts' }}"
                                class="nav-link {{ Request::url() == url('/accounts') ? 'active' : '' }}">
                                <i class="fa-solid fa-users-gear nav-icon"></i>
                                <p>Accounts</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="settings-link" href="{{ '/settings' }}"
                                class="nav-link {{ Request::url() == url('/settings') ? 'active' : '' }}">
                                <i class="fa-solid fa-gear nav-icon"></i>
                                <p>Settings</p>

                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper ">
            <section class="content p-2 overflow-auto "style="height:100vh">
                @yield('dashboard')

                @yield('unit_owners')
                @yield('view_owner_data')



                @yield('accounts')
                @yield('settings')
                <div class="h-25"></div>

            </section>
        </div>

        {{-- Loader --}}



        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <footer class="main-footer">
            <!-- Add footer content here -->
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>

    <script src="{{ asset('js/jquery.js') }}"></script>

    <script src="{{ asset('js/layout.js') }}"></script>

    <script></script>

</body>

</html>
