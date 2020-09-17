<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Laravel Teste</title>
  <link rel="stylesheet" href="css/app.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>


    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #001f3f">
      <!-- Brand Logo -->
      <a href="/users" class="brand-link">
        <img src="./img/contract.svg" alt="Laravel Teste Logo"
          class="brand-image img-circle elevation-3 background-teal" style="opacity: .8">
        <span class="brand-text font-weight-light">Laravel Teste</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

          {{-- <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}<span
                class="d-block text-muted">{{Auth::user()->getUserType()}} </span></a>
          </div> --}}
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
              <router-link :to="{ name: 'products' }" class=" nav-link">
                <i class="nav-icon fas fa-list-alt cyan"></i>
                <p>
                  List of Products
                </p>
              </router-link>
            </li>



            <li class="nav-item has-treeview ">
              <a href="#" class="nav-link ">
                <i class="nav-icon fas fa-cog indigo"></i>
                <p>
                  Settings
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link :to="{ name: 'users' }" class=" nav-link">
                    <i class="fas fa-users"></i>
                    <p>Users</p>
                  </router-link>
                </li>
              </ul>
            </li>




            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-power-off red"></i>
                <p>
                  {{ __('Logout') }}
                </p>
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <router-view></router-view>

          <vue-progress-bar></vue-progress-bar>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Laravel Teste
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2020 </strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->
  @auth
  <script>
    window.user = @json(auth()->user())
  </script>
  @endauth

  <script src="/js/app.js"></script>
</body>

</html>