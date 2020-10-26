<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
        integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('/css/admin.css')}}">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    @yield('css')
</head>

<body class="hold-transition sidebar-mini">
    <div id="app">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{route('dashboard')}}" class="brand-link">
                    <img src="/images/AdminLTELogo.png" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Admin panel</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            {{-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> --}}
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">{{auth()->user()->name}}</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <a href="{{route('dashboard')}}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="javascript:;" class="nav-link">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>Setting <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{route('setting.search')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Search</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="javascript:;" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Users <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{route('users.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('posts.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Posts</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="javascript:;" class="nav-link">
                                  <i class="nav-icon fas fa-database"></i>
                                  <p>
                                    Database
                                    <i class="fas fa-angle-left right"></i>
                                  </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{route('category.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Category
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('countries.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Countries</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('states.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>States</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('cities.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Cities</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('zipcodes.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Zipcodes</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('languages.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Languages</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('referrers.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Referrers</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('services.index')}}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Services</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="container-fluid">
                    @if(session()->has('success'))
                    <div class="alert alert-success mt-4 mb-4" role="alert">
                        {{session()->get('success')}}
                    </div>
                    @elseif(session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{session()->get('error')}}
                    </div>
                    @endif
                </div>

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        @yield('breadcrumb')
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- ./wrapper -->
    </div>

    <script src="{{ mix('/js/admin.js') }}"></script>
    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    {{-- <script src="/js/bootstrap.bundle.min.js"></script> --}}
    <!-- AdminLTE App -->
    <script src="/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="../../dist/js/demo.js"></script> --}}
</body>

</html>
