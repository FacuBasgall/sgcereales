@extends('reporte.index')
@section('result')
@parent

<head>
</head>

<body>
    <div>
        <table>
            <h4>Busqueda por:</h4>
            <thead>
                <tr>
                    <th>Fecha desde</th>
                    <th>Fecha hasta</th>
                    <th>Titular carta porte</th>
                    <th>Intermediario</th>
                    <th>Remitente comercial</th>
                    <th>Corredor</th>
                    <th>Destinatario</th>
                    <th>Entregador</th>
                    <th>Producto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @if($filtros["fechaDesde"] != "")
                        <td>{{$filtros["fechaDesde"]}}</td>
                    @else
                        <td>Filtro no aplicado</td>
                    @endif
                    @if($filtros["fechaHasta"] != "")
                        <td>{{$filtros["fechaHasta"]}}</td>
                    @else
                        <td>Filtro no aplicado</td>
                    @endif
                    @if($filtros["titular"] != "")
                        <td>{{$filtros["titular"]}}</td>
                    @else
                        <td>Filtro no aplicado</td>
                    @endif
                    @if($filtros["intermediario"] != "")
                        <td>{{$filtros["intermediario"]}}</td>
                    @else
                        <td>Filtro no aplicado</td>
                    @endif
                    @if($filtros["remitente"] != "")
                        <td>{{$filtros["remitente"]}}</td>
                    @else
                        <td>Filtro no aplicado</td>
                    @endif
                    @if($filtros["corredor"] != "")
                        <td>{{$filtros["corredor"]}}</td>
                    @else
                        <td>Filtro no aplicado</td>
                    @endif
                    @if($filtros["destinatario"] != "")
                        <td>{{$filtros["destinatario"]}}</td>
                    @else
                        <td>Filtro no aplicado</td>
                    @endif
                    @if($filtros["entregador"] != "")
                        <td>{{$filtros["entregador"]}}</td>
                    @else
                        <td>Filtro no aplicado</td>
                    @endif
                    @if($filtros["producto"] != "")
                        <td>{{$filtros["producto"]}}</td>
                    @else
                        <td>Filtro no aplicado</td>
                    @endif
                </tr>
            </tbody>
        </table>
        <br>
        <table>
            @if(!empty($resultado) && $resultado->count())
            <h4>Datos encontrados:</h4>
            <thead>
                <tr>
                    <th>Nro de aviso</th>
                    <th>Fecha de creación</th>
                    <th>Titular carta porte</th>
                    <th>Intermediario</th>
                    <th>Remitente comercial</th>
                    <th>Corredor</th>
                    <th>Destinatario</th>
                    <th>Producto</th>
                    <th>Procedencia</th>
                    <th>Destino</th>
                    <th>Neto descargado (Kg)</th>
                    <th>Neto con merma (Kg)</th>
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
                    <th>Total descargado (Kg):</th>
                    <td>{{$total}}</td>
                </tr>
                <tr>
                    <th>Total descargado con merma (Kg):</th>
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
