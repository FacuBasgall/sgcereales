@extends('layout.master-admin')
@section('content')
@parent

<head>
    <!-- Links de dataTable -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dataTable/jquery.dataTables.min.css') }}">
    <script type="text/javascript" src="/dataTable/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cortar-aviso.css') }}">
</head>

<body style="font-family: sans-serif;">
    <div class="cuadro">
        <div class="card">
            <div class="card-header">
                <label class="title col-md-8 col-form-label"><b>Gestión de usuarios</b></label>
                <a href="{{ action('AdminController@create') }}"><button class="plus-button" title="Crear usuario"><i
                            class="fa fa-plus"></i> Crear usuario</button></a>
            </div>
            <div class="card-body border">
                <table id="idDataTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th><strong>Nombre de usuario</strong></th>
                            <th><strong>Nombre y Apellido</strong></th>
                            <th><strong>CUIT</strong></th>
                            <th><strong>Rol</strong></th>
                            <th><strong>Estado</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $usuarios as $usuario)
                        <tr>
                            <td>{{$usuario->username}}</td>
                            <td>{{$usuario->nombre}}</td>
                            <td>{{$usuario->cuit}}</td>
                            @if($usuario->tipoUser == 'E')
                            <td>Entregador</td>
                            @else
                            <td>Administrador</td>
                            @endif
                            @if($usuario->habilitado)
                            <td style="color:green;">Habilitado<a href="{{ action('AdminController@change_status', $usuario->idUser) }}"><button
                                        class="show-button" title="Cambiar estado" style="padding: 7px;"><i
                                            class="fa fa-refresh"></i></button></a>
                            </td>
                            @else
                            <td style="color:red;">Deshabilitado<a href="{{ action('AdminController@change_status', $usuario->idUser) }}"><button
                                        class="show-button" title="Cambiar estado" style="padding: 7px;"><i
                                            class="fa fa-refresh"></i></button></a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
<script>
$(document).ready(function() {
    $('#idDataTable').DataTable({
        "order": [
            [0, "asc"]
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ usuarios",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando usuarios del _START_ al _END_ de un total de _TOTAL_ usuarios",
            "sInfoEmpty": "Mostrando usuarios del 0 al 0 de un total de 0 usuarios",
            "sInfoFiltered": "(filtrado de un total de _MAX_ usuarios)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        }
    });
});
</script>
<style>
.title {
    font-size: 19px;
}

.card-header {
    background-color: #ffffffd2;
}
</style>
@endsection
