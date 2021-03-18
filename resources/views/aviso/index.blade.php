@extends('layout.master')
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
                <label class="title col-md-8 col-form-label"><b>Listado de Avisos</b></label>
                <a href="{{ action('AvisoController@create') }}"><button class="plus-button" title="Crear Aviso"><i class="fa fa-plus"></i> Crear Aviso</button></a>
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
                            <th>Fecha de creación</th>
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
                            <td>
                                <div class="cortar">{{$aviso->entregador}}</div>
                            </td>
                            @else
                            <td>
                                <div class="cortar">{{auth()->user()->nombre}}</div>
                            </td>
                            @endif

                            @foreach ($productos as $producto)
                            @if ($producto->idProducto == $aviso->idProducto)
                            <td>{{$producto->nombre}}</td>
                            @endif
                            @endforeach

                            @foreach ($titulares as $titular)
                            @if ($titular->cuit == $aviso->idTitularCartaPorte)
                            <td>
                                <div class="cortar">{{ $titular->nombre }}</div>
                            </td>
                            @endif
                            @endforeach
                            @foreach ($remitentes as $remitente)
                            @if ($remitente->cuit == $aviso->idRemitenteComercial)
                            <td>
                                <div class="cortar">{{ $remitente->nombre }}</div>
                            </td>
                            @endif
                            @endforeach
                            @foreach ($corredores as $corredor)
                            @if ($corredor->cuit == $aviso->idCorredor)
                            <td>
                                <div class="cortar">{{ $corredor->nombre }}</div>
                            </td>
                            @endif
                            @endforeach
                            @foreach ($provincias as $provincia)
                            @if ($provincia->id == $aviso->provinciaProcedencia)
                            @foreach ($localidades as $localidad)
                            @if ($localidad->id == $aviso->localidadProcedencia)
                            <td>
                                <div class="cortar">{{$localidad->nombre}} ({{$provincia->abreviatura}})</div>
                            </td>
                            @endif
                            @endforeach
                            @endif
                            @endforeach
                            @foreach ($destinatarios as $destinatario)
                            @if ($destinatario->cuit == $aviso->idDestinatario)
                            <td>
                                <div class="cortar">{{ $destinatario->nombre }}</div>
                            </td>
                            @endif
                            @endforeach
                            <td>
                                <div class="cortar">{{$aviso->lugarDescarga}}</div>
                            </td>

                            <td>{{$aviso_entregador->fecha}}</td>

                            @if ($aviso->estado == true)
                            <td style="color: green;">Terminado</td>
                            @else
                            <td style="color: red;">Pendiente</td>
                            @endif
                            <td>
                                <a href="{{ action('AvisoController@show', $aviso->idAviso) }}"><button class="show-button" title="Ver más" style="padding: 7px;"><i class="fa fa-eye"></i> Ver</button></a>
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
                [9, "desc"],
                [0, "desc"]
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