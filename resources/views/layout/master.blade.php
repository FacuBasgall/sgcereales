<head>
    <!-- Navbar menu -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Navbar/bootstrap-home.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Navbar/bootstrap.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/navbarMenu/bootstrap.min.js') }}"></script>
    <!-- sweet alert -->
    <script type="text/javascript" src="{{ asset('js/sweetAlertJs.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/sweetAlert.js') }}"></script>
    <!-- Loading animation -->
    <script type="text/javascript" src="{{ asset('js/loading.js') }}"></script>
    <!-- common buttons in the app -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">

    <!-- lib jquery 3.3.1 -->
    <script type="text/javascript" src="{{ asset('js/navbarMenu/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <!-- select2 v4.1.0-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2/select2.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2/select2es.js') }}"></script>

    <!-- Header de camino de hormiga-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">

    <!-- config app -->
    <meta charset="utf-8">
    <title>Sistema Gestor de Cereales</title>
    <!------ Include the above in your HEAD tag ---------->
</head>

<body>
    <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark" style="font-family:sans-serif;">
        <a class="navbar-brand" href="{{action('HomeController@index')}}" title="Inicio">
            <div class="img">
                <img src="{{ URL::to('/image/SGC.jpg') }}">
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown" id="aviso">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" title="Avisos">
                        <i class="fa fa-newspaper-o"></i>
                        Avisos
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="ultimos" title="Muestra avisos de hasta 30 días atrás"><a href="{{ action('AvisoController@index') }}" class="dropdown-item">Últimos</a></li>
                        <li id="pendientes" title="Muestra avisos pendientes"><a href="{{ action('AvisoController@pending') }}" class="dropdown-item">Pendientes</a></li>
                        <li id="historia" title="Muestra avisos de más de 30 días de antiguedad"><a href="{{ action('AvisoController@history') }}" class="dropdown-item">Históricos</a></li>
                        <li id="agregar" title="Crear un nuevo aviso"><a href="{{ action('AvisoController@create') }}" class="dropdown-item">Crear aviso</a></li>
                    </ul>
                </li>
                <li class="nav-item" id="producto">
                    <a class="nav-link" href="{{ action('ProductoController@index') }}" title="Productos">
                        <i class="fa fa-leaf"></i>
                        Productos
                    </a>
                </li>
                <li class="nav-item dropdown" id="titular">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" title="Titulares">
                        <i class="fa fa-address-card"></i>
                        Titulares
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="titulares"><a href="{{ action('TitularController@index') }}" class="dropdown-item">Ver todos</a></li>
                        <li id="creartitular"><a href="{{ action('TitularController@create') }}" class="dropdown-item">Crear titular</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown" id="intermediario">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" title="Intermediarios">
                        <i class="fa fa-users"></i>
                        Intermediarios
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="intermediarios"><a href="{{ action('IntermediarioController@index') }}" class="dropdown-item">Ver todos</a></li>
                        <li id="crearintermediario"><a href="{{ action('IntermediarioController@create') }}" class="dropdown-item">Crear intermediario</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown" id="remitente">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" title="Remitentes">
                        <i class="fa fa-user"></i>
                        Remitentes
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="remitente"><a href="{{ action('RemitenteController@index') }}" class="dropdown-item">Ver todos</a></li>
                        <li id="crearremitente"><a href="{{ action('RemitenteController@create') }}" class="dropdown-item">Crear remitente</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown" id="destino">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" title="Destinatarios">
                        <i class="fa fa-truck"></i>
                        Destinatarios
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="destino"><a href="{{ action('DestinoController@index') }}" class="dropdown-item">Ver todos</a></li>
                        <li id="creardestino"><a href="{{ action('DestinoController@create') }}" class="dropdown-item">Crear destinatario</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown" id="corredor">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" title="Corredores">
                        <i class="fa fa-handshake-o"></i>
                        Corredores
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="corredor"><a href="{{ action('CorredorController@index') }}" class="dropdown-item">Ver todos</a></li>
                        <li id="crearcorredor"><a href="{{ action('CorredorController@create') }}" class="dropdown-item">Crear corredor</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown" id="reporte">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" title="Reportes">
                        <i class="fa fa-bar-chart"></i>
                        Reportes
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="reporte1"><a href="{{ action('ReporteController@summary') }}" class="dropdown-item">Resumen de avisos</a></li>
                        <li id="reporte2"><a href="{{ action('ReporteController@products') }}" class="dropdown-item">Resumen de productos</a></li>
                        <li id="reporte3"><a href="{{ action('ReporteController@productivity') }}" class="dropdown-item">Productividad</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown" id="usuario">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" title="Configuración">
                        <i class="fa fa-cog">
                        </i>
                        Configuraciones
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="show"><a href="{{action('UsuarioController@show')}}" class="dropdown-item">Perfil de
                                usuario</a></li>
                        <li id="acerca"><a onclick="acercaDe();" class="dropdown-item">Acerca de</a></li>
                        <li id="manual"><a href="{{action('HomeController@manualuser')}}" class="dropdown-item">Manual de usuario</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('logout')}}" title="Cerrar Sesión">
                        <i class="fa fa-power-off">
                        </i>
                        Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="loader" class="center"></div>
    @yield('content')
    <script>
        $(document).ready(function() {
            var loc = window.location.href; // grabbing the url
            var str = loc.split("/")[3]; // splitting the url and taking the third string
            if (str.localeCompare("") == 0)
                $("#home").addClass("active");
            else
                $("#" + str).addClass("active");
        });

        $(function() {
            $(".dropdown").hover(
                function() {
                    $('.dropdown-menu', this).stop(true, true).fadeIn("fast");
                    $(this).toggleClass('open');
                    $('b', this).toggleClass("caret caret-up");
                },
                function() {
                    $('.dropdown-menu', this).stop(true, true).fadeOut("fast");
                    $(this).toggleClass('open');
                    $('b', this).toggleClass("caret caret-up");
                });
        });
    </script>
    @include('sweet::alert')
</body>