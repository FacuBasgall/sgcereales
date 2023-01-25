@extends('layout.master')
@section('content')
@parent

<head>
    <!-- Links de dataTable -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dataTable/jquery.dataTables.min.css') }}">
    <script type="text/javascript" src="/dataTable/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/general-reports.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cortar-aviso.css') }}">
</head>

<body style="font-family: sans-serif;">
    <div class="card">
        <div class="card-header">
            <label class="title col-md-8 col-form-label">Reportes
                <i class="fa fa-chevron-right"></i> Resumen de avisos terminados (discriminados por cargas/descargas)</label>
        </div>
        <div class="container">
            <div class="header-card">
                <form action="{{action('ReporteController@summary')}}" method="GET">
                    {{ csrf_field() }}
                    <label for="fechaDesde">
                        <span>Fecha desde*:</span>
                        <input class="common-input" type="date" value="{{$fechadesde}}" name="fechaDesde" id="fechaDesde" required>
                    </label>
                    <label for="fechaHasta">
                        <span>Fecha hasta*:</span>
                        <input class="common-input" type="date" value="{{$fechahasta}}" name="fechaHasta" id="fechaHasta" required>
                    </label>
                    <label class="margin-right" for="titular">
                        <span>Titular carta porte:</span>
                        <select class="common-input" name="titular" id="labeltitular">
                            <option value=""></option>
                            @foreach ($titulares as $t)
                            <option value="{{ $t->cuit }}" {{$titular == $t->cuit ? 'selected':''}}>
                                {{$t->nombre}}
                            </option>
                            @endforeach
                        </select>
                        <script>
                            $.fn.select2.defaults.set('language', 'es');
                            $("#labeltitular").select2({
                                placeholder: 'Seleccione',
                                dropdownAutoWidth: true,
                                allowClear: true
                            });
                        </script>
                    </label>
                    <label class="margin-right" for="remitente">
                        <span>Remitente comercial:</span>
                        <select class="common-input" name="remitente" id="labelremitente">
                            <option value=""></option>
                            @foreach ($remitentes as $r)
                            <option value="{{ $r->cuit }}" {{$remitente == $r->cuit ? 'selected':''}}>
                                {{$r->nombre}}
                            </option>
                            @endforeach
                        </select>
                        <script>
                            $.fn.select2.defaults.set('language', 'es');
                            $("#labelremitente").select2({
                                placeholder: 'Seleccione',
                                dropdownAutoWidth: true,
                                allowClear: true
                            });
                        </script>
                    </label>
                    <label class="margin-right" for="corredor">
                        <span>Corredor:</span>
                        <select class="common-input" name="corredor" id="labelcorredor">
                            <option value=""></option>
                            @foreach ($corredores as $c)
                            <option value="{{ $c->cuit }}" {{$corredor == $c->cuit ? 'selected':''}}>
                                {{$c->nombre}}
                            </option>
                            @endforeach
                        </select>
                        <script>
                            $.fn.select2.defaults.set('language', 'es');
                            $("#labelcorredor").select2({
                                placeholder: 'Seleccione',
                                dropdownAutoWidth: true,
                                allowClear: true
                            });
                        </script>
                    </label>
                    <label class="margin-right" for="destinatario">
                        <span>Destinatario:</span>
                        <select class="common-input" name="destinatario" id="labeldestinatario">
                            <option value=""></option>
                            @foreach ($destinatarios as $d)
                            <option value="{{ $d->cuit }}" {{$destinatario == $d->cuit ? 'selected':''}}>
                                {{$d->nombre}}
                            </option>
                            @endforeach
                        </select>
                        <script>
                            $.fn.select2.defaults.set('language', 'es');
                            $("#labeldestinatario").select2({
                                placeholder: 'Seleccione',
                                dropdownAutoWidth: true,
                                allowClear: true
                            });
                        </script>
                    </label>
                    <label class="margin-right" for="producto">
                        <span>Producto:</span>
                        <select class="common-input" name="producto" id="labelproducto">
                            <option value=""></option>
                            @foreach ($productos as $p)
                            <option value="{{ $p->idProducto }}" {{$producto == $p->idProducto ? 'selected':''}}>
                                {{$p->nombre}}
                            </option>
                            @endforeach
                        </select>
                        <script>
                            $.fn.select2.defaults.set('language', 'es');
                            $("#labelproducto").select2({
                                placeholder: 'Seleccione',
                                dropdownAutoWidth: true,
                                allowClear: true
                            });
                        </script>
                    </label>
                    <label for="entregador">
                        <span>Entregador:</span>
                        <input type="text" value="{{old('entregador')}}" name="entregador" class="common-input" list="entregador" maxlength="50">
                        <datalist id="entregador">
                            <option value=""></option>
                            @foreach ((array)$entregadores as $e)
                            <option value="{{$e->entregador}}" {{$entregador == $e->entregador ? 'selected':''}}></option>
                            {{$e->entregador}}
                            @endforeach
                        </datalist>
                    </label>
                    <div><label class="info-text-margin"><i class="fa fa-exclamation-circle"></i>
                            Los campos con * son obligatorios</label></div>
                    <div class="center-of-page"><button type="submit" class="find-button"><i class="fa fa-search" aria-hidden="true"></i>
                            Buscar</button></div>
                </form>
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
                            <th>Neto (Kg)</th>
                            <th>Neto merma (Kg)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; $totalMerma = 0; @endphp
                        @if($avisos != NULL)
                        @foreach($avisos as $aviso)
                        <tr>
                            <td>{{ $aviso->nroAviso }}</td>
                            @if ($aviso->entregador == NULL)
                            <td>
                                <div class="cortar">{{$nombreEntregador}}</div>
                            </td>
                            @else
                            <td>
                                <div class="cortar">{{$aviso->entregador}}</div>
                            </td>
                            @endif
                            <td>
                                <div class="cortar">{{$aviso->productoNombre}}</div>
                            </td>
                            <td>
                                <div class="cortar">{{$aviso->titularNombre}}</div>
                            </td>
                            <td>
                                <div class="cortar">{{$aviso->remitenteNombre}}</div>
                            </td>
                            <td>
                                <div class="cortar">{{$aviso->corredorNombre}}</div>
                            </td>
                            <td>
                                <div class="cortar">{{$aviso->localidadNombre}} ({{$aviso->provinciaAbreviatura}})</div>
                            </td>
                            <td>
                                <div class="cortar">{{$aviso->destinatarioNombre}}</div>
                            </td>
                            <td>
                                <div class="cortar">{{$aviso->lugarDescarga}}</div>
                            </td>
                            @php
                            $descargado = round($aviso->bruto - $aviso->tara);
                            $merma = round(($aviso->bruto - $aviso->tara) * ($aviso->merma / 100));
                            $total += $descargado; $totalMerma += ($descargado - $merma);
                            @endphp
                            <td>{{$descargado}}</td>
                            <td>{{($descargado - $merma)}}</td>
                            <td>
                                <a href="{{ action('AvisoController@show', $aviso->idAviso) }}"><button class="show-button" title="Ver más" style="padding: 7px;"><i class="fa fa-eye"></i> Ver</button></a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <div>
                    <strong>Total descargado (Kg):</strong> {{$total}}
                    <strong>Total descargado con merma (Kg):</strong> {{$totalMerma}}
                </div>
            </div>
        </div>
        <div class="center-of-page">
            <a href="{{action('ReporteController@export_excel')}}"><button class="export-button"><i class="fa fa-file-excel-o"></i>
                    Descargar Excel</button></a>
            <a href="{{action('ReporteController@export_pdf')}}"><button class="export-button"><i class="fa fa-file-pdf-o"></i>
                    Descargar PDF</button></a>
            <a href="{{action('ReporteController@load_email')}}"><button class="export-button"><i class="fa fa-envelope"></i>
                    Enviar</button></a>
        </div>
    </div>
    @include('sweet::alert')
</body>
<script>
    $(document).ready(function() {
        $('#idDataTable').DataTable({
            "order": [
                [0, "desc"]
            ],
            "searching": false,
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ cargas/descargas",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "No hay datos disponibles. Realice una nueva búsqueda para obtener resultados",
                "sInfo": "Mostrando cargas/descargas del _START_ al _END_ de un total de _TOTAL_ cargas/descargas",
                "sInfoEmpty": "Mostrando cargas/descargas del 0 al 0 de un total de 0 cargas/descargas",
                "sInfoFiltered": "(filtrado de un total de _MAX_ cargas/descargas)",
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