<head>
</head>

<body>
    <div>

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
</body>

