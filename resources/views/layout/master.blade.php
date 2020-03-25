
<head>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="{{ asset('css/bootstrap-home.min.css') }}" rel="stylesheet">
  <!------ Include the above in your HEAD tag ---------->
</head>
<body>
  <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{action('HomeController@index')}}">
      <div class="img">
          <img src="{{ URL::to('/image/SGC.jpg') }}">
      </div>
    </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
          <a class="nav-link" href="{{ action('AvisoController@index') }}">
            <i class="fa fa-newspaper-o"></i>
            Avisos
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ action('ProductoController@index') }}">
            <i class="fa fa-leaf"></i>
            Productos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ action('CargadorController@index') }}">
            <i class="fa fa-user-o"></i>
            Cargadores
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ action('DestinoController@index') }}">
            <i class="fa fa-truck"></i>
            Destinatarios
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ action('CorredorController@index') }}">
            <i class="fa fa-handshake-o"></i>
            Corredores
          </a>
        </li>

      </ul>
      <ul class="navbar-nav ">
        <li class="nav-item">
          <a class="nav-link" href="#" title="Manual de usuario">
            <i class="fa fa-book">
            </i>
            Manual de Usuario
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Cerrar sesión">
            <i class="fa fa-power-off">
            </i>
            Cerrar sesión
          </a>
        </li>
      </ul>
    </div>
  </nav>
  @yield('content')
</body>
