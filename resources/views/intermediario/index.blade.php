@extends('layout.master')
@section('content')
@parent

<head>
    <!-- Links de dataTable -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dataTable/jquery.dataTables.min.css') }}">
    <script type="text/javascript" src="/dataTable/jquery.dataTables.min.js"></script>
</head>

<body style="font-family: sans-serif;">
    <div class="cuadro">
        <div class="card">
            <div class="card-header">
                <label class="title col-md-8 col-form-label"><b>Intermediarios</b></label>
                <a href="{{ action('IntermediarioController@create') }}"><button class="plus-button"
                title="Añadir intermediario"><i class="fa fa-plus"></i> Añadir</button></a>
            </div>
            <div class="card-body border">
                <table id="idDataTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>CUIT</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($arrayIntermediario as $intermediario)
                        <tr>
                            <td>{{ $intermediario->cuit }}</td>
                            <td>
                                <div>{{$intermediario->nombre}}</div>
                            </td>
                            <td>
                                <a href="{{ action('IntermediarioController@show', $intermediario->cuit) }}"><button class="show-button" title="Ver más" style="padding: 7px;"><i class="fa fa-eye"></i> Ver</button></a>
                                <a onclick="warning( '{{$intermediario->cuit}}' , 'intermediario');"><button class="delete-button" title="Eliminar"><i class="fa fa-trash"></i> Borrar</button></a>                            
                            </td>
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
                [1, 'asc']
            ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ intermediarios",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando intermediarios del _START_ al _END_ de un total de _TOTAL_ intermediarios",
                "sInfoEmpty": "Mostrando intermediarios del 0 al 0 de un total de 0 intermediarios",
                "sInfoFiltered": "(filtrado de un total de _MAX_ intermediarios)",
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
