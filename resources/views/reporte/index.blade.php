@extends('layout.master')
@section('content')
@parent

<head>
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
</head>

<body>
    <div>
        <form action="{{action('ReporteController@index')}}" method="GET">
            {{ csrf_field() }}
            <label for="fechaDesde">
                <span>Fecha desde:*</span>
                <input type="date" value="{{$filtros['fechaDesde']}}" name="fechaDesde" id="fechaDesde" class="input" required>
            </label>
            <label for="fechaHasta">
                <span>Fecha hasta:*</span>
                <input type="date" value="{{$filtros['fechaHasta']}}" name="fechaHasta" id="fechaHasta" class="input" required>
            </label>
            <label for="titular">
                <span>Titular Carta Porte:</span>
                <select name="titular" id="labeltitular" class="input">
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
            <label for="intermediario">
                <span>Intermediario:</span>
                <select name="intermediario" id="labelintermediario" class="input">
                    <option value=""></option>
                    @foreach ($intermediarios as $intermediario)
                    <option value="{{ $intermediario->cuit }}"
                        {{$filtros['intermediario'] == $intermediario->cuit ? 'selected':''}}>
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
            <label for="remitente">
                <span>Remitente Comercial:</span>
                <select name="remitente" id="labelremitente" class="input">
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
            <label for="corredor">
                <span>Corredor:</span>
                <select name="corredor" id="labelcorredor" class="input">
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
            <label for="destinatario">
                <span>Destinatario:</span>
                <select name="destinatario" id="labeldestinatario" class="input">
                    <option value=""></option>
                    @foreach ($destinatarios as $destinatario)
                    <option value="{{ $destinatario->cuit }}"
                        {{$filtros['destinatario'] == $destinatario->cuit ? 'selected':''}}>{{$destinatario->nombre}}
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
            <label for="producto">
                <span>Producto:</span>
                <select name="producto" class="input" id="labelproducto">
                    <option value=""></option>
                    @foreach ($productos as $producto)
                    <option value="{{ $producto->idProducto }}"
                        {{$filtros['producto'] == $producto->idProducto ? 'selected':''}}> {{$producto->nombre}}</option>
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
                <input type="text" value="{{$filtros['entregador']}}" name="entregador" id="entregador" class="input">
            </label>
            <button type="submit">Buscar</button>
        </form>
        <hr>
    </div>
    <div>
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
                            <td>{{$aviso_entregador->fecha}}</td>
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
                <h4>No se han encontrado resultados.</h4>
            @endif
        </table>
    </div>
    @include('sweet::alert')
</body>
@endsection
