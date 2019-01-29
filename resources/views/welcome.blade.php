<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Glosarium LibreOffice Indonesia</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/now-ui-kit.css?v=1.2.0') }}" rel="stylesheet" />
  <style>
  .login-page .page-header::before{
    background-color: rgba(0,0,0,0.1);
  }
  .footer {
    background-color: rgba(0,0,0,0.2)
  }
  .footer .copyright {
    float: left;
    /* font-size: 1.0rem; */
  }
  .footer nav {
    float: right
  }
  .footer ul li a{
    text-transform: none;
    /* font-size: 1.0rem; */
  }
  .login-page .card-login {
    max-width: 500px;
  }
  .login-page .input-lg {
    font-size: 1rem;
  }
  .login-page .content {
    margin-top: 25vh;
  }
  </style>
</head>
<body class="login-page sidebar-collapse">
  @if (Route::has('login'))
    <nav class="navbar navbar-expand-lg bg-primary fixed-top navbar-transparent ">
      <div class="container">
        <div class="navbar-translate">
          <button class="ml-auto navbar-toggler navbar-toggler collapsed " type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-bar top-bar"></span>
           <span class="navbar-toggler-bar middle-bar"></span>
           <span class="navbar-toggler-bar bottom-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navigation" style='background: rgba(0, 0, 0, 0) url("../assets/img/blurred-image-1.jpg") repeat scroll 0% 0% / cover;' data-nav-image="../assets/img/blurred-image-1.jpg">
          <ul class="navbar-nav">
            @auth
              <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Dasbor</a></li>
            @else
              {{-- <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li> --}}
              {{-- <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li> --}}
            @endauth
            <li class="nav-item"><a class="nav-link" href="{{ url('/glosarium') }}">Daftar Kata/Padanan</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">Tentang</a></li>
            <li class="nav-item"><a class="nav-link" target="_blank" href="https://goo.gl/forms/ImukgcQcGzdqx8SC2">Usulkan Kata/Padanan</a></li>
          </ul>
        </div>
      </div>
    </nav>
  @endif
  {{-- <div class="wrapper" > --}}
    <div class="page-header clear-filter" filter-color="green">
      <div class="page-header-image" style="background-image:url({{ asset('img/latar.svg') }})"></div>
      <div class="container">
      <div class="content">
        <div class="row">
          <div class="col-md-6 mx-auto">
            <div class="card card-login card-plain">
  
              <div class="card-header text-center">
                <img src="{{ asset('img/main-logo.png') }}" alt="">
              </div>
  
              <div class="card-body">
                <form class="form" action="{{ route('cari') }}" method="post">
                  {{ csrf_field() }}
                  <div class="input-group no-border input-lg">
                    <div class="input-group-prepend" for="lema"><span class="input-group-text"><i class="now-ui-icons ui-1_zoom-bold"></i></span></div>
                    <input class="form-control" placeholder="Cari Padanan ..." type="text" name="lema" >
                  </div>
                </form>
              </div>
            </div>
          </div>
  
        </div>
  
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <div class="copyright">Komunitas <b>Libre</b>Office Indonesia</div>
            <nav>
              <ul>
                <li><a href="https://github.com/libreofficeid"><i class="fab fa-github"></i><span class="d-none d-lg-inline">&nbsp;&nbsp;@libreofficeid</span></a></li>
                <li><a href="mailto:humas@libreoffice.id"><i class="fa fa-envelope"></i><span class="d-none d-lg-inline">&nbsp;&nbsp;humas@libreoffice.id</span></a></li>
                <li><a href="https://twitter.com/libreofficeid"><i class="fab fa-twitter"></i><span class="d-none d-lg-inline">&nbsp;&nbsp;@LibreOfficeID</span></a></li>
                <li><a href="https://t.me/LibreOfficeID"><i class="fab fa-telegram-plane"></i><span class="d-none d-lg-inline">&nbsp;&nbsp;@LibreOfficeID</span></a></li>
              </ul>
            </nav>
        </div>
      </footer>
    </div>
  {{-- </div> --}}
  <!--   Core JS Files   -->
  <script src="{{ asset('js/core/jquery.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/core/popper.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/core/bootstrap.min.js') }}" type="text/javascript"></script>
  {{-- <script src="{{ asset('js/core/app.js') }}" type="text/javascript"></script> --}}
  <script src="{{ asset('js/now-ui-kit.js') }}" type="text/javascript"></script>
</body>
</html>
