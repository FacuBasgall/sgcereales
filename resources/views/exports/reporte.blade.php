<div>
    <table>
        <thead>
            <tr>
                <th rowspan="6" colspan="6" valign="middle"><b>
                        {{$entregador->nombre}}<br>
                        {{$entregador->descripcion}}<br>
                        @foreach ($entregador_domicilio as $domicilio)
                        @foreach($provincias as $provincia)
                        @if($provincia->id == $domicilio->provincia)
                        @foreach($localidades as $localidad)
                        @if($localidad->id == $domicilio->localidad)
                        {{$domicilio->domicilio}}, {{$localidad->nombre}} ({{$provincia->abreviatura}} -
                        {{$domicilio->cp}})<br>
                        @endif
                        @endforeach
                        @endif
                        @endforeach
                        @endforeach
                        @foreach ($entregador_contacto as $contacto)
                        | {{$contacto->contacto}} |
                        @endforeach
                    </b>
                </th>
                <th>Resumen General de Descarga</th>
            </tr>
            <tr>
                <th><strong>Fecha desde</strong></th>
                <td>{{$filtros->fechaDesde}}</td>
            </tr>
            <tr>
                <th><strong>Fecha hasta</strong></th>
                <td>{{$filtros->fechaHasta}}</td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <th><strong>Número</strong></th>
                <th><strong>Fecha</strong></th>
                <th><strong>Titular</strong></th>
                <th><strong>Intermediario</strong></th>
                <th><strong>Remitente</strong></th>
                <th><strong>Corredor</strong></th>
                <th><strong>Destinatario</strong></th>
                <th><strong>Producto</strong></th>
                <th><strong>Tipo</strong></th>
                <th><strong>Cosecha</strong></th>
                <th><strong>Procedencia</strong></th>
                <th><strong>Destino</strong></th>
                <th><strong>Neto (Kg)</strong></th>
                <th><strong>Neto merma (Kg)</strong></th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; $totalMerma = 0; @endphp
            @foreach ($resultados as $resultado)
            <tr>
                <td>{{$resultado->nroAviso}}</td>
                <td>{{date("d/m/Y", strtotime($resultado->fecha))}}</td>
                @foreach ($titulares as $titular)
                @if($titular->cuit == $resultado->idTitularCartaPorte)
                <td>
                    <div>{{$titular->nombre}}</div>
                </td>
                @endif
                @endforeach
                @foreach ($intermediarios as $intermediario)
                @if($intermediario->cuit == $resultado->idIntermediario)
                <td>
                    <div>{{$intermediario->nombre}}</div>
                </td>
                @endif
                @endforeach
                @foreach ($remitentes as $remitente)
                @if($remitente->cuit == $resultado->idRemitenteComercial)
                <td>
                    <div>{{$remitente->nombre}}</div>
                </td>
                @endif
                @endforeach
                @foreach ($corredores as $corredor)
                @if($corredor->cuit == $resultado->idCorredor)
                <td>
                    <div>{{$corredor->nombre}}</div>
                </td>
                @endif
                @endforeach
                @foreach ($destinatarios as $destinatario)
                @if($destinatario->cuit == $resultado->idDestinatario)
                <td>
                    <div>{{$destinatario->nombre}}</div>
                </td>
                @endif
                @endforeach
                @foreach ($productos as $producto)
                @if($producto->idProducto == $resultado->idProducto)
                <td>
                    <div>{{$producto->nombre}}</div>
                </td>
                @endif
                @endforeach
                <td>{{$resultado->tipo}}</td>
                <td>{{$resultado->cosecha}}</td>
                @foreach ($provincias as $provincia)
                @if ($provincia->id == $resultado->provinciaProcedencia)
                @foreach ($localidades as $localidad)
                @if ($localidad->id == $resultado->localidadProcedencia)
                <td>
                    <div>{{$localidad->nombre}} ({{$provincia->abreviatura}})</div>
                </td>
                @endif
                @endforeach
                @endif
                @endforeach
                <td>
                    <div>{{$resultado->lugarDescarga}}</div>
                </td>
                @php $descargado = 0; $merma = 0 @endphp
                @foreach($descargas as $descarga)
                @if($descarga->idAviso == $resultado->idAviso)
                @php
                $descargado += $descarga->bruto - $descarga->tara;
                $merma += round(($descarga->bruto - $descarga->tara) * ($descarga->merma / 100));
                @endphp
                @endif
                @endforeach
                <td>{{$descargado}}</td>
                <td>{{$descargado - $merma}}</td>
                @php $total += $descargado; $totalMerma += ($descargado - $merma); @endphp
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <div>
        <th>Total descargado (Kg):</th>
        <td>{{$total}}</td>
        <th>Total descargado con merma (Kg):</th>
        <td>{{$totalMerma}}</td>
    </div>
</div>
