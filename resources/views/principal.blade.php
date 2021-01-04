<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.1.10
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="es">
  <head>
    <!--<base href="./">-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Imprenta Express-Trabajos">
    <meta name="author" content="">

    <title>Imprenta Express-Trabajos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="192x192" href="{{ url('images/icons/android-icon-192x192.png') }}">


    <link href=" {{ asset('admin/node_modules/@coreui/icons/css/coreui-icons.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('admin/node_modules/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('admin/node_modules/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('admin/node_modules/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">

    <link href=" {{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link href=" {{ asset('admin/vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">

  </head>
  <body class="app header-fixed sidebar-fixed sidebar-lg-show footer-fixed">
   <div id="app">

    <header class="app-header navbar">
      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="/main">
        <img class="navbar-brand-full" src=" {{ asset('admin/img/brand/logo-ie.svg') }} " width="150" height="70" alt="Imprenta Express Logo">
        <img class="navbar-brand-minimized" src=" {{ asset('admin/img/brand/logo-ie.svg') }} " width="30" height="30" alt="Imprenta Express Logo">
      </a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>

      <ul class="nav navbar-nav ml-auto">


        <li class="nav-item d-md-down-none">
          <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
           <span class="d-md-down-none">{{Auth::user()->nombre}} </span>
           <img class="img-avatar" src=" {{ asset('admin/img/avatars/avatar.png') }}" >
          </a>

        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-lock"></i> Cerrar sesión</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

        </li>

      </ul>

    </header>
     <div class="app-body">

      @if(Auth::check())
          @if (Auth::user()->role == 'Administrador')
              @include('menus.menuadmin')
          @elseif (Auth::user()->role == 'System')
              @include('menus.menusystem')
          @elseif (Auth::user()->role == 'Diseñador')
              @include('menus.menudisenador')
          @elseif (Auth::user()->role == 'Vendedor')
              @include('menus.menuvendedor')
          @endif
      @endif

      <!--Contenido Principal-->
      @yield('contenido')
      <!--Fin Contenido Principal-->

     </div>
     <!--Fin app body-->
   </div>
   <!--Fin id app -->

    <footer class="app-footer">
       <div>
        <a href="#">Imprenta Express</a>
        <span>&copy; 2020 </span>
       </div>
    </footer>


    <script src="{{ asset('admin/node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admin/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('admin/node_modules/pace-progress/pace.min.js') }}"></script>
    <script src="{{ asset('admin/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/node_modules/@coreui/coreui/dist/js/coreui.min.js') }}"></script>

   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script> -->

    <script src="js/app.js"></script>



  </body>
</html>
