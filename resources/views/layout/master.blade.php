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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item" id="aviso">
                    <a class="nav-link" href="{{ action('AvisoController@index') }}" title="Avisos">
                        <i class="fa fa-newspaper-o"></i>
                        Avisos
                    </a>
                </li>
                <li class="nav-item" id="producto">
                    <a class="nav-link" href="{{ action('ProductoController@index') }}" title="Productos">
                        <i class="fa fa-leaf"></i>
                        Productos
                    </a>
                </li>
                <li class="nav-item" id="titular">
                    <a class="nav-link" href="{{ action('TitularController@index') }}" title="Titulares Carta Porte">
                        <i class="fa fa-address-card"></i>
                        Titulares
                    </a>
                </li>
                <li class="nav-item" id="intermediario">
                    <a class="nav-link" href="{{ action('IntermediarioController@index') }}" title="Intermediarios">
                        <i class="fa fa-users"></i>
                        Intermediarios
                    </a>
                </li>
                <li class="nav-item" id="remitente">
                    <a class="nav-link" href="{{ action('RemitenteController@index') }}" title="Remitentes Comerciales">
                        <i class="fa fa-user"></i>
                        Remitentes
                    </a>
                </li>
                <li class="nav-item" id="destino">
                    <a class="nav-link" href="{{ action('DestinoController@index') }}" title="Destinatarios">
                        <i class="fa fa-truck"></i>
                        Destinatarios
                    </a>
                </li>
                <li class="nav-item" id="corredor">
                    <a class="nav-link" href="{{ action('CorredorController@index') }}" title="Corredores">
                        <i class="fa fa-handshake-o"></i>
                        Corredores
                    </a>
                </li>
                <li class="nav-item dropdown" id="reporte">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" title="Reportes">
                        <i class="fa fa-bar-chart"></i>
                        Reportes
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="descarga"><a href="{{ action('ReporteController@summary') }}"
                                class="dropdown-item">Resumen de avisos</a></li>
                        <li id="dos"><a href="#" class="dropdown-item">Segundo reporte</a></li>
                        <li id="tres"><a href="#" class="dropdown-item">Tercer reporte</a></li>
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
                        <li id="manual"><a href="#" class="dropdown-item">Manual de usuario</a></li>
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
