<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a051b84b57.js" crossorigin="anonymous"></script>

    <title>@yield('title')</title>
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="{{ asset('js/layout.js') }}"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

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



        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="toast-message" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong id="toast-text-color" class="me-auto ">
                        <i id="toast-icon-success" class="fa-solid fa-circle-check me-3  d-none"></i>
                        <i id="toast-icon-failed" class="fa-solid fa-circle-xmark me-3 d-none"></i>
                        <span id="toast-header-text"></span>
                    </strong>
                    <button type="button" id=clearModal class="btn-close" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">

                </div>
            </div>
        </div>


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

        <div class="modal fade" id="confirmActionModal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="unit-ownerLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel"><i
                                class="fa-solid fa-building-un"></i>
                            <span id="confirmActionLabel"></span>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="confirmActionMessage"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-value="yes" class="confirmActionBtn btn btn-primary"
                            id='confirm-delete-unit-rental'>Yes</button>
                        <button type="button" data-value="no" class="confirmActionBtn btn btn-danger"
                            data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Loader --}}



        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <footer class="main-footer">
            <!-- Add footer content here -->
        </footer>
    </div>
    <!-- ./wrapper -->
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>


    <script>
        $(document).ready(function() {
            Mailer()
        });
    </script>

</body>

</html>
