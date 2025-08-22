<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" class="img-circle elevation-2" href="{!! asset('dist/img/logo.png') !!}"/>

    <style type="text/css">
        @media print {
            @page { margin: 0mm; }
            body { margin: 20mm; }
            .print-header {
                    position: fixed;
                    top: -10mm;
            }
        }
        .pos-card-text-title {
            font-size: 16px;
            font-weight: ;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .pos-card-text-body {
            font-size: 14px;
            font-weight: normal;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .round {
            position: relative;
        }

        .round label {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 50%;
            cursor: pointer;
            height: 28px;
            left: 0;
            position: absolute;
            top: 0;
            width: 28px;
        }

        .round label:after {
            border: 2px solid #fff;
            border-top: none;
            border-right: none;
            content: "";
            height: 6px;
            left: 7px;
            opacity: 0;
            position: absolute;
            top: 8px;
            transform: rotate(-45deg);
            width: 12px;
        }

        .round input[type="checkbox"] {
            visibility: hidden;
        }

        .round input[type="checkbox"]:checked+label {
            background-color: #66bb6a;
            border-color: #66bb6a;
        }

        .round input[type="checkbox"]:checked+label:after {
            opacity: 1;
        }

        i.fax {
            display: inline-block;
            background-color: #ededed;
            border-radius: 60px;
            box-shadow: 0 0 2px #ededed;
            padding: 0.8em 0.9em;


        }

        body {
            font-size: 3.2vw;
        }
    </style>

    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <link rel="stylesheet" href="{{ asset('css/fontawesome/fonts.googleapis.css') }}">



    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}

    <!-- Bootstrap 5 -->
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap/bootstrap.min.css.map') }}">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    {{-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" /> --}}

    <!-- Data table -->

    <link rel="stylesheet" href="{{ asset('dataTable/datatables.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('dataTable/Buttons-2.2.2/css/buttons.bootstrap5.min.css') }}"> -->



    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">


    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">


    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

    <!-- Select2 -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap-select.min.css') }}">


    <!-- PrintJS -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('https://printjs-4de6.kxcdn.com/print.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('dist/css/print.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/fileinput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fileinput-rtl.min.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.5/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /> --}}

    <!-- jquery loader -->
    <link rel="stylesheet" type="text/css" href="{{ asset('loader/css/jquery.loadingModal.min.css') }}">
    <link rel="stylesheet" type="text/javascript" href="{{ asset('loader/scss/jquery.loadingModal.scss') }}">

    <!-- Pace  -->
    {{-- <link rel="stylesheet" href="{{ asset('pace/css/pace-theme-flat-top.css') }}"> --}}
    <!-- <link rel="stylesheet" href="{{ asset('pace/css/pace-theme-loading-bar.css') }}"> -->

    <!-- jQuery treeview -->
    <!-- <link rel="stylesheet" href="{{ asset('dist/css/bstreeview.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('dist/themes/default/style.min.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('dist/themes/default-dark/style.min.css') }}" /> -->

    <!-- JQUERY -->
    <script src="{{ asset('dist/js/jquery 3.5.1/jquery.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr/toastr.css') }}">
    {{--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <!-- <style type="text/css">
        .main-sidebar { background-color: $your-color !important }
    </style> -->
    <style>
        .thumbPic {
            margin: 10px 5px 0 0;
            width: 300px;
            padding: 2px;
        }
        .thumbPic {
            margin: 10px 5px 0 0;
            width: 300px;
            padding: 2px;
        }
        /* Default Dark Mode Styling */
        .dark-mode {
            background-color: #121212;
            color: #e6e6e6;
        }

        /* Add specific styles as needed */
        .dark-mode .navbar {
            background-color: #1c1c1c;
            border-color: #333333;
        }
        .dark-mode .navbar-nav .nav-link {
            color: rgb(254 254 254);
        }
        .dark-mode .nav-link {
            /* color: #e6e6e6 !important; */
        }
        /* Table background and text color in night mode */
        .dark-mode .dataTable {
            background-color: #1c1c1c;
            color: #e6e6e6;
        }

        /* Header background and text color */
        .dark-mode .dataTable thead th {
            background-color: #333333;
            color: #e6e6e6;
        }
        .dark-mode label {
            display: inline-block;
            color: white;
        }

        /* Pagination and control styles */
        .dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #e6e6e6 !important;
            background-color: #2e3844;
            border: 1px solid #444444;
        }

        .dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: #e6e6e6 !important;
            background-color: #555555;
        }

        /* Search input and dropdown styles */
        .dark-mode .dataTables_wrapper .dataTables_filter input,
        .dark-mode .dataTables_wrapper .dataTables_length select {
            background-color: #333333;
            color: #e6e6e6;
            border: 1px solid #444444;
        }

        /* Info and processing text */
        .dark-mode .dataTables_wrapper .dataTables_info {
            color: #e6e6e6;
        }

        .dark-mode .dataTables_wrapper .dataTables_processing {
            color: #e6e6e6;
        }
        /* Odd row styling for night mode */
        .dark-mode .dataTable tbody tr.odd,
        .dark-mode .dataTable tbody tr.odd td {
            background-color: #2e3844 !important;
            color: #e6e6e6 !important;
        }
        .dark-mode .dataTable tbody tr.even td,
        .dark-mode .dataTable tbody tr.even td {
            background-color: #4b5766 !important;
            color: #e6e6e6 !important;
        }
        .dark-mode table.dataTable tbody tr {
            background-color: #2e3844 !important;
            color: #e6e6e6 !important;
        }
        /* Simulated fullscreen */
        .simulated-fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #838383;
            overflow: hidden;
            z-index: 9999;
        }
        .dark-mode button.dt-button,
        .dark-mode div.dt-button,
        .dark-mode a.dt-button,
        .dark-mode input.dt-button {
            color: #e6e6e6 !important;
            background-color: #333333 !important;
        }

        .dark-mode div.dt-button-collection.fixed {
            background-color: #2e3844 !important;
            color: #ffffff !important;
            border-color: #444444 !important;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
        }

        .dark-mode div.dt-button-collection.fixed button.dt-button,
        .dark-mode div.dt-button-collection.fixed a.dt-button {
            background-color: #2e3844 !important;
            color: #ffffff !important;
            border-color: #555555 !important;
        }

        .dark-mode div.dt-button-collection.fixed button.dt-button:hover,
        .dark-mode div.dt-button-collection.fixed a.dt-button:hover {
            background-color: #444444 !important;
            color: #ffffff !important;
        }

        .dark-mode div.dt-button-collection button.dt-button.active:not(.disabled),
        .dark-mode div.dt-button-collection a.dt-button.active:not(.disabled) {
            background-color: #444444 !important;
            color: #060606 !important;
            border-color: #555555 !important;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
        }

        .image {
            position: relative;
            display: inline-block;
        }

        .active-dot {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background-color: rgb(56, 178, 56);
            border: 2px solid white;
            border-radius: 50%;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: #000000 !important;
        }
        #fullscreen-icon,
        #night-mode-icon {
            color: inherit;
            transition: none;
        }
        #fullscreen-btn:hover #fullscreen-icon,
        #night-mode-btn:hover #night-mode-icon {
            color: inherit;
        }

    </style>


</head>

<body class="hold-transition sidebar-mini layout-fixed pace-primary">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id='selfclick' data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('/home') }}" class="nav-link">Home</a>
                </li>

            </ul>



            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <!-- Night Mode Button -->
                <li class="nav-item">
                    <a class="nav-link" href="#" role="button" id="night-mode-btn" style="padding-top: 17px; padding-bottom: 0;">
                        <i class="fas fa-moon" id="night-mode-icon"></i>
                    </a>
                </li>

                <!-- Fullscreen Button -->
                <li class="nav-item">
                    <a class="nav-link" href="#" role="button" id="fullscreen-btn" style="padding-top: 17px; padding-bottom: 0;">
                        <i class="fas fa-expand" id="fullscreen-icon"></i>
                    </a>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link notification" data-toggle="dropdown" href="#" style="padding-top:0px;padding-left:4px;padding-right:0px;height:40px;padding-bottom:0px;width: 70px;">
                        {{-- <i class="fax fa fa-user-cog"></i> --}}
                        <div class="user-panel mt-2 pb-2 mb-2" style="position: relative;">
                            <div class="image" style="position: relative;">
                                <img src="{{ asset('dist/img/user1.png') }}" alt="User Image" style="height: 38px; width: 38px;">
                                <span class="active-dot"></span>
                            </div>
                        </div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="d-block text-left" style="padding-left:15px;">{{ auth()->user()->name }}</a>
                        <div class="dropdown-divider"></div>
                            <a href="{{ route('reset.password') }}" class="dropdown-item">
                                <i class="fas fa-unlock mr-2"></i>Reset Password
                            </a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>


                    </div>
                </li>
            </ul>
        </nav>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const fullscreenBtn = document.getElementById("fullscreen-btn");
                const fullscreenIcon = document.getElementById("fullscreen-icon");
                const nightModeBtn = document.getElementById("night-mode-btn");
                const nightModeIcon = document.getElementById("night-mode-icon");
                const body = document.body;

                // Check and apply stored states from LocalStorage
                const isNightMode = localStorage.getItem("nightMode") === "true";
                const isFullscreen = localStorage.getItem("fullscreen") === "true";

                if (isNightMode) {
                    enableNightMode();
                }

                if (isFullscreen) {
                    enableFullscreen();
                }

                // Night mode toggle
                nightModeBtn.addEventListener("click", function () {
                    body.classList.contains("dark-mode") ? disableNightMode() : enableNightMode();
                });

                // Full-screen toggle
                fullscreenBtn.addEventListener("click", function () {
                    document.fullscreenElement ? disableFullscreen() : enableFullscreen();
                });

                function enableNightMode() {
                    body.classList.add("dark-mode");
                    nightModeIcon.classList.replace("fa-moon", "fa-sun");
                    localStorage.setItem("nightMode", "true");
                    updateDataTablesStyles(true);
                }

                function disableNightMode() {
                    body.classList.remove("dark-mode");
                    nightModeIcon.classList.replace("fa-sun", "fa-moon");
                    localStorage.setItem("nightMode", "false");
                    updateDataTablesStyles(false);
                }

                function enableFullscreen() {
                    document.documentElement.requestFullscreen();
                    fullscreenIcon.classList.replace("fa-expand", "fa-compress");
                }

                function disableFullscreen() {
                    document.exitFullscreen();
                    fullscreenIcon.classList.replace("fa-compress", "fa-expand");
                }

                function updateDataTablesStyles(isNightMode) {
                    const tables = document.querySelectorAll(".dataTable");
                    tables.forEach((table) => {
                        isNightMode ? table.classList.add("table-dark") : table.classList.remove("table-dark");
                    });
                }

                // Handle exiting fullscreen through other means
                document.addEventListener("fullscreenchange", function () {
                    if (!document.fullscreenElement) {
                        disableFullscreen();
                    }
                });
            });

        </script>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">


            <div class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-2 pb-2 mb-2">
                    <div class="image">
                        <a href="{{ url('/home') }}">
                        <img src="{{ asset('dist/img/walock.png') }}" style="width:80%;"class="img elevation-2"
                            alt="User Image">
                    </div>
                    {{-- <div class="info">
                        <a href="{{ url('/dashboard') }}" class="d-block"><b>Walock</b></a>
                    </div> --}}
                </div>
                {{-- <div class="user-panel mt-2 pb-2 mb-2">
                    <div class="image">
                        <img src="{{ asset('dist/img/user1.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div> --}}

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    @php
                    $user = auth()->user();
                    @endphp
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        {{-- <li class="nav-item">
                            @if ($user && $user->company_id == 0)
                                <a href="{{ url('/company') }}" class="nav-link">
                                    <i class="fas fa-building nav-icon"></i>
                                    <p>Company</p>
                                </a>
                            @else
                                <a href="{{ url('/profile') }}" class="nav-link">
                                    <i class="fas fa-user-circle nav-icon"></i>
                                    <p>Profile</p>
                                </a>
                            @endif
                        </li> --}}


                        {{-- @can('dashboard.view') --}}
                        {{-- <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li> --}}


                        @hasanyrole('Admin|Developer|Company Admin')
                            <li class="nav-item">
                                <a href="{{ url('/presidents') }}" class="nav-link">
                                    <i class="fas fa-users nav-icon"></i>
                                    <p>
                                        President
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/secretaries') }}" class="nav-link">
                                    <i class="fas fa-users nav-icon"></i>
                                    <p>
                                        Secretary
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/voters') }}" class="nav-link">
                                    <i class="fas fa-users nav-icon"></i>
                                    <p>
                                        Voters
                                    </p>
                                </a>
                            </li>
                        @endhasanyrole

                        @hasanyrole('Admin|Developer')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>
                                        User Management
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                @can('user.create')
                                    <ul class="nav nav-treeview pl-3">
                                        <li class="nav-item">
                                            <a href="{{ url('/create-user') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>
                                                    Create User
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                                @can('user.list.view')
                                    <ul class="nav nav-treeview pl-3">
                                        <li class="nav-item">
                                            <a href="{{ url('/users-list') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>
                                                    Users List
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                                @can('user.status.view')
                                    <ul class="nav nav-treeview pl-3">
                                        <li class="nav-item">
                                            <a href="{{ url('/users-status') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>
                                                    Users Status
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                                {{-- @can('activity.log.view')
                                    <ul class="nav nav-treeview pl-3">
                                        <li class="nav-item">
                                            <a href="{{ url('/activity-log') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>
                                                    Activity Log
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                                @can('roles.list.view')
                                    <ul class="nav nav-treeview pl-3">
                                        <li class="nav-item">
                                            <a href="{{ url('/role-list') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>
                                                    Roles List
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan --}}
                                {{-- @can('permission.list.view')
                                    <ul class="nav nav-treeview pl-3">
                                        <li class="nav-item">
                                            <a href="{{ url('/permission-list') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>
                                                    Permission List
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                                @can('permission.group.list.view')
                                    <ul class="nav nav-treeview pl-3">
                                        <li class="nav-item">
                                            <a href="{{ url('/permission-group-list') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>
                                                    Permission Group List
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan --}}
                            </li>
                        @endhasanyrole
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Main content -->
        <div class="row">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>
        <div class="row">
            <div class="layout-footer-fixed">
                <footer class="main-footer">
                    <strong>Copyright &copy; <a href="https://inovexidea.com/">INovex Idea Solution</a>.</strong>
                    All rights reserved.
                </footer>
            </div>

        </div>
    </div>
    <!-- ./wrapper -->


    <!-- REQUIRED SCRIPTS -->
    @yield('script')

    <!-- jQuery -->
    @yield('jQuery')

    <!-- jQuery -->

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            var url = window.location;
            $('ul.nav-sidebar a').filter(function() {
                return this.href == url;
            }).addClass('active');

            $('ul.nav-treeview a').filter(function() {
                    return this.href == url;
                }).parentsUntil(".nav-sidebar > .nav-treeview")
                .css({
                    'display': 'block'
                })
                .addClass('menu-open').prev('a')
                .addClass('active');
        });
    </script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <!-- Bootstrap 5 -->
    <script src="{{ asset('dist/js/umd/popper.min.js') }}"></script>

    {{-- <script src="{{ asset('dist/js/bootstrap/bootstrap.min.js') }}"></script> --}}

    <!-- DataTable -->

    <script src="{{ asset('dataTable/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('dataTable/Buttons-2.2.2/js/buttons.bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('dataTable/JSZip-2.5.0/jszip.min.js') }}"></script>
    <script src="{{ asset('dataTable/pdfmake-0.1.36/pdfmake.js') }}"></script>
    <script src="{{ asset('dataTable/pdfmake-0.1.36/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dataTable/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dataTable/Buttons-2.2.2/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dataTable/Buttons-2.2.2/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dataTable/Responsive-2.2.9/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dataTable/Buttons-2.2.2/js/buttons.colVis.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    {{-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}

    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>

    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>

    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>

    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>

    <!-- Notify JS -->
    <script src="{{ asset('dist/js/notify.min.js') }}"></script>

    <!-- Print a div -->
    <script src="{{ asset('dist/js/jQuery.print.min.js') }}"></script>

    <!-- <script type="text/javascript" src="https://printjs-4de6.kxcdn.com/print.min.js"></script> -->
    <script type="text/javascript" src="{{ asset('dist/js/print.min.js') }}"></script>






    <!-- Select2 -->
    <!-- Latest compiled and minified JavaScript -->
    {{-- <script src="{{ asset('dist/js/bootstrap/bootstrap-select.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript" src="{{ asset('kartik-v-bootstrap-fileinput-ab06a9c/js/plugins/piexif.min.js') }}">
    </script>

    <script type="text/javascript" src="{{ asset('kartik-v-bootstrap-fileinput-ab06a9c/js/plugins/sortable.min.js') }}">
    </script>

    <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
        dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    {{-- <script src="{{ asset('dist/js/bootstrap/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> --}}

    <!-- the main fileinput plugin script JS file -->
    <script type="text/javascript" src="{{ asset('kartik-v-bootstrap-fileinput-ab06a9c/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap-fileinput@5.2.5/LANG.js') }}"></script>

    <script src="{{ asset('loader/js/jquery.loadingModal.min.js') }}"></script>



    <!-- pace -->
    <script src="{{ asset('pace/js/pace.min.js') }}"></script>


    <!-- jQuery treeView -->
    <!-- <script src="{{ asset('dist/js/bstreeview.min.js') }}"></script> -->

    <script src="{{ asset('dist/jstree.min.js') }}"></script>


    {{-- <script type="text/javascript" src="{{ asset('scripts/toastr/toastr.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('scripts/toastr/sweetalert2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('scripts/sweetalert/icon.js') }}"></script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

</body>

</html>
