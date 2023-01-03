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
                <label class="title col-md-8 col-form-label"><b>Gestión de localidades</b></label>
                <a href="{{action('LocalidadController@create')}}">
                    <button class="plus-button" title="Añadir localidad"><i class="fa fa-plus"></i> Añadir</button></a>
            </div>
            <div class="card-body border">
                <table id="idDataTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Provincia</th>
                            <th>Localidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($localidades as $localidad)
                        <tr>
                            <td>{{$localidad->nombreProvincia}}</td>
                            <td>{{$localidad->nombreLocalidad}}</td>
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
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ localidades",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando localidades del _START_ al _END_ de un total de _TOTAL_ localidades",
                "sInfoEmpty": "Mostrando localidades del 0 al 0 de un total de 0 localidades",
                "sInfoFiltered": "(filtrado de un total de _MAX_ localidades)",
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