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
        <a class="navbar-brand" href="{{action('AdminController@index')}}" title="Inicio">
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
                <li class="nav-item" id="usuarios">
                    <a class="nav-link" href="{{action('AdminController@view_users')}}" title="Gestión de usuarios">
                        <i class="fa fa-users"></i> Gestión de usuarios
                    </a>
                </li>
                <li class="nav-item" id="perfil">
                    <a class="nav-link" href="{{action('AdminController@show')}}" title="Perfil">
                        <i class="fa fa-address-card"></i>
                        Perfil de usuario
                    </a>
                </li>
                <li class="nav-item" id="backup">
                    <a class="nav-link" onclick="warningBackup();" title="Copia de resguardo">
                        <i class="fa fa-database"></i>
                        Copia de resguardo
                    </a>
                </li>
                <li class="nav-item" id="manual">
                    <a class="nav-link" href="#" title="Manual de usuario">
                        <i class="fa fa-book"></i>
                        Manual de usuario
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
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
