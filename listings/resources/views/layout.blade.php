<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a051b84b57.js" crossorigin="anonymous"></script>

    <title>@yield('title')</title>

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
                <li class="nav-item">
                    <i class="fa-solid fa-bell mr-3" id='notifs-btn'></i>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/dashboard" class="brand-link">
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
                            <a id="contracts-link" href="{{ '/contracts' }}"
                                class="nav-link {{ Request::url() == url('/contracts') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-contract nav-icon"></i>
                                <p>Contracts</p>

                            </a>
                        </li>

                        <li
                            class="nav-item has-treeview {{ in_array(Request::url(), [url('/clients'), url('/agents'), url('/coordinators')]) ? 'menu-open' : '' }} ">
                            <a href="#"
                                class="nav-link       {{ in_array(Request::url(), [url('/clients'), url('/agents'), url('/coordinators')]) ? 'active' : '' }}  ">
                                <i class="fa-solid fa-users nav-icon"></i>
                                <p>Partners<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ '/clients' }}"
                                        class="nav-link  {{ Request::url() == url('/clients') ? 'active menu-open' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Clients</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ '/coordinators' }}"
                                        class="nav-link  {{ Request::url() == url('/coordinators') ? 'active menu-open' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Coordinators</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ '/agents' }}"
                                        class="nav-link  {{ Request::url() == url('/agents') ? 'active menu-open' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Agents</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="nav-item has-treeview         {{ in_array(Request::url(), [url('/projects'), url('/properties'), url('/buildings'), url('/units')]) ? 'menu-open' : '' }} ">
                            <a href="#"
                                class="nav-link       {{ in_array(Request::url(), [url('/projects'), url('/properties'), url('/buildings'), url('/units')]) ? 'active' : '' }}  ">
                                <i class="fa-solid fa-building nav-icon"></i>
                                <p>Assets<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ '/projects' }}"
                                        class="nav-link  {{ Request::url() == url('/projects') ? 'active menu-open' : '' }}   {{ Request::url() == url('/buildings') ? 'active menu-open' : '' }}{{ Request::url() == url('/units') ? 'active menu-open' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Projects</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ '/properties' }}"
                                        class="nav-link  {{ Request::url() == url('/properties') ? 'active menu-open' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Properties</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li
                            class="nav-item has-treeview         {{ in_array(Request::url(), [url('/projects'), url('/import'), url('/export')]) ? 'menu-open' : '' }} ">
                            <a href="#"
                                class="nav-link       {{ in_array(Request::url(), [url('/projects'), url('/import'), url('/export')]) ? 'active' : '' }}  ">
                                <i class="fa-solid fa-file nav-icon"></i>
                                <p>File<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ '/export' }}"
                                        class="nav-link  {{ Request::url() == url('/export') ? 'active menu-open' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Export</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ '/import' }}"
                                        class="nav-link  {{ Request::url() == url('/import') ? 'active menu-open' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Import</p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                    </ul>
                </nav>
            </div>
        </aside>



        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="toasMessage" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto" id="toast-header"></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <span id="toast-content"></span>
                </div>
            </div>
        </div>


        <div class="content-wrapper ">
            <section class="content p-2 overflow-auto "style="height:100vh; position:relative;">
                <div id='notifs' class="bg-white d-none">

                </div>

                @yield('dashboard')
                @yield('contracts')
                @yield('clients')
                @yield('coordinators')
                @yield('agents')
                @yield('projects')
                @yield('buildings')
                @yield('units')
                @yield('properties')
                @yield('import')
                @yield('export')

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
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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

    <script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>
    <script src="{{ asset('js/layout.js') }}"></script>

</body>

</html>
