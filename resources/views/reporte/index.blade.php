@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/general-reports.css') }}">
</head>

<body>
    <div class="container">
        <div class="header-card">
            <div class="header-title">Reportes generales</div>
            <form action="{{action('ReporteController@index')}}" method="GET">
                {{ csrf_field() }}
                <label for="fechaDesde">
                    <span>Fecha desde*:</span>
                    <input class="common-input" type="date" value="{{$filtros['fechaDesde']}}" name="fechaDesde" id="fechaDesde" required>
                </label>
                <label for="fechaHasta">
                    <span>Fecha hasta*:</span>
                    <input class="common-input" type="date" value="{{$filtros['fechaHasta']}}" name="fechaHasta" id="fechaHasta" required>
                </label>
                <label class="margin-right" for="titular">
                    <span>Titular carta porte:</span>
                    <select class="common-input" name="titular" id="labeltitular">
                        <option value=""></option>
                        @foreach ($titulares as $titular)
                        <option value="{{ $titular->cuit }}" {{$filtros['titular'] == $titular->cuit ? 'selected':''}}>
                            {{$titular->nombre}}</option>
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
                <label class="margin-right" for="intermediario">
                    <span>Intermediario:</span>
                    <select class="common-input" name="intermediario" id="labelintermediario">
                        <option value=""></option>
                        @foreach ($intermediarios as $intermediario)
                        <option value="{{ $intermediario->cuit }}" {{$filtros['intermediario'] == $intermediario->cuit ? 'selected':''}}>
                            {{$intermediario->nombre}}</option>
                        @endforeach
                    </select>
                    <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#labelintermediario").select2({
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
                        @foreach ($remitentes as $remitente)
                        <option value="{{ $remitente->cuit }}" {{$filtros['remitente'] == $remitente->cuit ? 'selected':''}}>
                            {{$remitente->nombre}}</option>
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
                        @foreach ($corredores as $corredor)
                        <option value="{{ $corredor->cuit }}" {{$filtros['corredor'] == $corredor->cuit ? 'selected':''}}>
                            {{$corredor->nombre}}</option>
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
                        @foreach ($destinatarios as $destinatario)
                        <option value="{{ $destinatario->cuit }}" {{$filtros['destinatario'] == $destinatario->cuit ? 'selected':''}}>{{$destinatario->nombre}}
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
                        @foreach ($productos as $producto)
                        <option value="{{ $producto->idProducto }}" {{$filtros['producto'] == $producto->idProducto ? 'selected':''}}> {{$producto->nombre}}</option>
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
                    <input class="common-input" type="text" value="{{$filtros['entregador']}}" name="entregador" id="entregador">
                </label>
                <button type="submit" class="find-button"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
            </form>
        </div>
        <div class="results-card">
            <table>
                @if(!empty($resultado) && $resultado->count())
                <h4>Datos encontrados:</h4>
                <thead>
                    <tr>
                        <th><strong>Nro de aviso</strong></th>
                        <th><strong>Fecha de creación</strong></th>
                        <th><strong>Titular carta porte</strong></th>
                        <th><strong>Intermediario</strong></th>
                        <th><strong>Remitente comercial</strong></th>
                        <th><strong>Corredor</strong></th>
                        <th><strong>Destinatario</strong></th>
                        <th><strong>Producto</strong></th>
                        <th><strong>Procedencia</strong></th>
                        <th><strong>Destino</strong></th>
                        <th><strong>Neto descargado (Kg)</strong></th>
                        <th><strong>Neto con merma (Kg)</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; $totalMerma = 0; @endphp
                    @foreach ($resultado as $aviso)
                    <tr>
                        <td>{{$aviso->nroAviso}}</td>
                        @foreach ($avisos_entregadores as $aviso_entregador)
                        @if($aviso_entregador->idAviso == $aviso->idAviso)
                        <td>{{date("d/m/Y", strtotime($aviso_entregador->fecha))}}</td>
                        @endif
                        @endforeach
                        @foreach ($titulares as $titular)
                        @if($titular->cuit == $aviso->idTitularCartaPorte)
                        <td>{{$titular->nombre}}</td>
                        @endif
                        @endforeach
                        @foreach ($intermediarios as $intermediario)
                        @if($intermediario->cuit == $aviso->idIntermediario)
                        <td>{{$intermediario->nombre}}</td>
                        @endif
                        @endforeach
                        @foreach ($remitentes as $remitente)
                        @if($remitente->cuit == $aviso->idRemitenteComercial)
                        <td>{{$remitente->nombre}}</td>
                        @endif
                        @endforeach
                        @foreach ($corredores as $corredor)
                        @if($corredor->cuit == $aviso->idCorredor)
                        <td>{{$corredor->nombre}}</td>
                        @endif
                        @endforeach
                        @foreach ($destinatarios as $destinatario)
                        @if($destinatario->cuit == $aviso->idDestinatario)
                        <td>{{$destinatario->nombre}}</td>
                        @endif
                        @endforeach
                        @foreach ($productos as $producto)
                        @if($producto->idProducto == $aviso->idProducto)
                        <td>{{$producto->nombre}}</td>
                        @endif
                        @endforeach
                        @foreach ($provincias as $provincia)
                        @if ($provincia->id == $aviso->provinciaProcedencia)
                        @foreach ($localidades as $localidad)
                        @if ($localidad->id == $aviso->localidadProcedencia)
                        <td>{{$localidad->nombre}} ({{$provincia->abreviatura}})</td>
                        @endif
                        @endforeach
                        @endif
                        @endforeach
                        <td>{{$aviso->lugarDescarga}}</td>
                        @php $descargado = 0; $merma = 0 @endphp
                        @foreach ($cargas as $carga)
                        @if($carga->idAviso == $aviso->idAviso)
                        @foreach ($descargas as $descarga)
                        @if($descarga->idCarga == $carga->idCarga)
                        @php
                        $descargado += $descarga->bruto - $descarga->tara;
                        $merma += round(($descarga->bruto - $descarga->tara) * ($descarga->merma / 100));
                        @endphp
                        @endif
                        @endforeach
                        @endif
                        @endforeach
                        <td>{{$descargado}}</td>
                        <td>{{$descargado - $merma}}</td>
                        @php $total += $descargado; $totalMerma += ($descargado - $merma); @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <th><strong>Total descargado (Kg):</strong></th>
                        <td>{{$total}}</td>
                    </tr>
                    <tr>
                        <th><strong>Total descargado con merma (Kg):</strong></th>
                        <td>{{$totalMerma}}</td>
                    </tr>
                </tbody>
                @else
                <label class="no-results">Realice una búsqueda para obtener resultados</label>
                @endif
            </table>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection