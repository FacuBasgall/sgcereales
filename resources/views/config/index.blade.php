@extends('layout.master')
@section('content')
@parent


<!------ Include the above in your HEAD tag ---------->

<head>
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select-pais.js') }}"></script>
</head>

<!-- <style>
@import 'https://fonts.googleapis.com/css?family=Raleway:300,400';


body {
    font-family: 'Raleway:300', sans-serif
}

.admin-sidenav {
    width: auto;
    height: auto;
    margin-left: 0px;
}

.admin-sidenav a {
    text-decoration: none;
}

.admin-sidenav li {
    text-align: justify;
    padding: .5rem;
    padding-left: 1rem;
    -webkit-transition: all .2s linear;
    transition: all .2s linear;
    background-color: #000;
    border: 1px solid #333;
}

.admin-sidenav li a {
    color: #fff;
}

.admin-sidenav li a:active {
    border-color: #02d3f5;
}

.admin-sidenav li:hover {
    border-radius: 0 .5rem .5rem 0;
    border-color: #02d3f5;
    -webkit-transform: translate(30px, 0px);
    transform: translate(30px, 0px);
    background: -webkit-linear-gradient(left, #006a7b, #002340);
    background: linear-gradient(to right, #006a7b, #002340);
}

.admin-sidenav li:active {
    border-color: #02d3f5;
}
</style>

<body>
    <div class="container-fluid">
        <div class="row">
            <div id="admin-sidebar" class="col-md-2 p-x-0 p-y-3">
                <ul class="sidenav admin-sidenav list-unstyled">
                    <li><a href="{{action('UsuarioController@form_password')}}">Cambiar contraseña</a></li>
                    <li><a href="{{action('UsuarioController@show')}}">Datos personales</a></li>
                    <li><a href="{{action('UsuarioController@create')}}">Crear usuario</a></li>
                    <li><a href="#">Mensaje predeterminado e-mail</a></li>
                    <li><a href="{{action('ConfigController@show_backup')}}">Realizar copia de resguardo</a></li>
                </ul>
            </div> <!-- /#admin-sidebar -->
            <div id="admin-main-control">
                @yield('option')
            </div> <!-- /#admin-main-control -->
        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
    @include('sweet::alert')

</body> -->
@endsection
