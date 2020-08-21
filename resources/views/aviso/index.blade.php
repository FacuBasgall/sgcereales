@extends('layout.master')
@section('content')
@parent

<head>
    <!-- Links de dataTable -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dataTable/jquery.dataTables.min.css') }}">
    <script type="text/javascript" src="/dataTable/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="cuadro">
        <div class="card">
            <div class="card-header">
                <label class="title col-md-8 col-form-label"><b>Listado de Avisos</b></label>
                <a href="{{ action('AvisoController@create') }}"><button class="plus-button" title="Crear Aviso"><i
                            class="fa fa-plus"></i> Crear Aviso</button></a>
            </div>
            <div class="card-body border">
                <table id="idDataTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Entregador</th>
                            <th>Producto</th>
                            <th>Titular</th>
                            <th>Remitente</th>
                            <th>Corredor</th>
                            <th>Procedencia</th>
                            <th>Destinatario</th>
                            <th>Destino</th>
                            <th>Fecha de Creacion</th>
                            <th>Estado</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($avisos_entregadores as $aviso_entregador)
                        @foreach($avisos as $aviso)
                        @if($aviso->idAviso == $aviso_entregador->idAviso)
                        <tr>
                            <td>{{ $aviso->nroAviso }}</td>

                            @if (isset($aviso->entregador))
                            <td>{{$aviso->entregador}}</td>
                            @else
                            <td>{{$entregador->nombre}}</td>
                            @endif

                            @foreach ($productos as $producto)
                            @if ($producto->idProducto == $aviso->idProducto)
                            <td>{{$producto->nombre}}</td>
                            @endif
                            @endforeach

                            @foreach ($titulares as $titular)
                            @if ($titular->cuit == $aviso->idTitularCartaPorte)
                            <td>{{ $titular->nombre }}</td>
                            @endif
                            @endforeach
                            @foreach ($remitentes as $remitente)
                            @if ($remitente->cuit == $aviso->idRemitenteComercial)
                            <td>{{ $remitente->nombre }}</td>
                            @endif
                            @endforeach
                            @foreach ($corredores as $corredor)
                            @if ($corredor->cuit == $aviso->idCorredor)
                            <td>{{ $corredor->nombre }}</td>
                            @endif
                            @endforeach
                            <td>{{$aviso->localidadProcedencia}} ({{$aviso->provinciaProcedencia}})</td>
                            @foreach ($destinatarios as $destinatario)
                            @if ($destinatario->cuit == $aviso->idDestinatario)
                            <td>{{ $destinatario->nombre }}</td>
                            @endif
                            @endforeach
                            <td>{{$aviso->lugarDescarga}}</td>

                            <td>{{date("d/m/Y", strtotime($aviso_entregador->fecha))}}</td>

                            @if ($aviso->estado == true)
                            <td style="color: green;">Terminado</td>
                            @else
                            <td style="color: red;">Pendiente</td>
                            @endif
                            <td>
                                <a href="{{ action('AvisoController@show', $aviso->idAviso) }}"><button
                                        class="show-button" title="Ver más" style="padding: 7px;"><i
                                            class="fa fa-eye"></i> Ver</button></a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
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
            [9, "desc"]
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ avisos",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando avisos del _START_ al _END_ de un total de _TOTAL_ avisos",
            "sInfoEmpty": "Mostrando avisos del 0 al 0 de un total de 0 avisos",
            "sInfoFiltered": "(filtrado de un total de _MAX_ avisos)",
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
@stop
