<head>
    <!-- Navbar menu -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset('css/Navbar/bootstrap-home.min.css') }}" rel="stylesheet">
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/sweetAlert.js') }}"></script>
    <!-- Loading animation -->
    <script type="text/javascript" src="{{ asset('js/loading.js') }}"></script>
    <!-- common buttons in the app -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">

    <!-- lib jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>

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
                <li class="nav-item" id="reporte">
                    <a class="nav-link" href="{{ action('ReporteController@index') }}" title="Reportes Generales">
                        <i class="fa fa-bar-chart"></i>
                        Reportes Generales
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item" id="config">
                    <a class="nav-link" href="{{action('ConfigController@index')}}" title="Configuración Avanzada">
                        <i class="fa fa-cog">
                        </i>
                        Configuración <br>Avanzada
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('logout')}}" title="Cerrar Sesión">
                        <i class="fa fa-power-off">
                        </i>
                        Cerrar Sesión <br>{{auth()->user()->username}}
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
    </script>
</body>
