<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Glosarium LibreOffice Indonesia') }}</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/now-ui-kit.css') }}" rel="stylesheet" />
  <style media="screen">
    .navbar .form-control,.navbar .form-control::placeholder,.navbar .input-group-text {
      color: white !important
    }
    /* .text-primary, .text-primary a,{
      color: #17a204 !important;
    } */
    .bg-primary, .btn-primary, thead .bg-primary {
      background-color: #17a204 !important
    }
    .footer .copyright {
      float: left;
      font-size: 1.0rem;
    }
    .login-page .input-lg {
      font-size: 1rem;
    }
    .footer nav {
      float: right
    }
    .footer ul li a{
      text-transform: none;
      font-size: 1.0rem;
    }
    .footer {
      color: #FFF;
    }
  </style>
</head>
<body class="landing-page sidebar-collapse" style="background-image:url({{ asset('img/latar.svg') }})">
    
  <nav class="navbar navbar-expand-lg fixed-top bg-primary navbar-transparent" style="background-image:url({{ asset('img/latar.svg') }})">
    <div class="container">
      <div class="navbar-translate">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="{{ asset('img/main-logo.png') }}" alt="" width="128">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-bar top-bar"></span>
            <span class="navbar-toggler-bar middle-bar"></span>
            <span class="navbar-toggler-bar bottom-bar"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse justify-content-end" id="navigation" style='background: rgba(0, 0, 0, 0.0) url({{ asset('img/latar.svg') }}) repeat scroll 0% 0% / cover;'>        
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            @yield('kotakcari')
            <li class="nav-item"><a class="nav-link" href="{{ url('/glosarium') }}">Daftar Kata/Padanan</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">Tentang</a></li>
            <li class="nav-item"><a class="nav-link" href="https://goo.gl/forms/ImukgcQcGzdqx8SC2">Usulkan Kata/Padanan</a></li>
          <!-- Authentication Links -->
          @guest
          @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ url('/home') }}">Dasbor</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
<div class="wrapper">
    {{-- <div class="page-header clear-filter" filter-color="green" > --}}
        {{-- <div class="page-header-image" style="background-image:url({{ asset('img/latar.svg') }})"></div> --}}
  <div class="section section-about-us" style="min-height:100vh;">
    <div class="container p-3">
      @yield('content')
    </div>
  </div>
  <footer class="footer footer-default bg-primary">
    <div class="container">
      <div class="copyright" id="copyright">Komunitas <b>Libre</b>Office Indonesia</div>
      <nav>
        <ul>
          <li><a href="https://github.com/libreofficeid"><i class="fab fa-github"></i>&nbsp;&nbsp;@libreofficeid</a></li>
          <li><a href="mailto:humas@libreoffice.id"><i class="fa fa-envelope"></i>&nbsp;&nbsp;humas@libreoffice.id</a></li>
          <li><a href="https://twitter.com/libreofficeid"><i class="fab fa-twitter"></i>&nbsp;&nbsp;@LibreOfficeID</a></li>
          <li><a href="https://t.me/LibreOfficeID"><i class="fab fa-telegram-plane"></i>&nbsp;&nbsp;@LibreOfficeID</a></li>
        </ul>
      </nav>
    </div>
  </footer>
</div>
<div class="modal fade" id="modalMd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalMdTitle"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="modalMdContent"></div>
            </div>
        </div>
    </div>
  </div>
  <!-- Scripts -->
  <script src="{{ asset('js/core/jquery.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/core/popper.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/core/bootstrap.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/now-ui-kit.js?v=1.2.0') }}" type="text/javascript"></script>
  <script src="{{ asset('js/ajax-form.js') }}" type="text/javascript"></script>
</body>
</html>
