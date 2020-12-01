<table>
    <thead>
        <tr>
            <div style="vertical-align:middle; display:inherit;">
                <th rowspan="6" colspan="2"><b>
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
            </div>
            <th><b>Resumen General de Descarga</b></th>
        </tr>
        <tr>
            <th><b style="font-weight:bold">Fecha desde: {{$filtros->fechaDesde}}</b></th>
        </tr>
        <tr>
            <th><b style="font-weight:bold">Fecha hasta: {{$filtros->fechaHasta}}</b></th>
        </tr>
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
                {{$titular->nombre}}
            </td>
            @endif
            @endforeach
            @foreach ($intermediarios as $intermediario)
            @if($intermediario->cuit == $resultado->idIntermediario)
            <td>
                {{$intermediario->nombre}}
            </td>
            @endif
            @endforeach
            @foreach ($remitentes as $remitente)
            @if($remitente->cuit == $resultado->idRemitenteComercial)
            <td>
                {{$remitente->nombre}}
            </td>
            @endif
            @endforeach
            @foreach ($corredores as $corredor)
            @if($corredor->cuit == $resultado->idCorredor)
            <td>
                {{$corredor->nombre}}
            </td>
            @endif
            @endforeach
            @foreach ($destinatarios as $destinatario)
            @if($destinatario->cuit == $resultado->idDestinatario)
            <td>
                {{$destinatario->nombre}}
            </td>
            @endif
            @endforeach
            @foreach ($productos as $producto)
            @if($producto->idProducto == $resultado->idProducto)
            <td>
                {{$producto->nombre}}
            </td>
            @endif
            @endforeach
            @foreach ($provincias as $provincia)
            @if ($provincia->id == $resultado->provinciaProcedencia)
            @foreach ($localidades as $localidad)
            @if ($localidad->id == $resultado->localidadProcedencia)
            <td>
                {{$localidad->nombre}} ({{$provincia->abreviatura}})
            </td>
            @endif
            @endforeach
            @endif
            @endforeach
            <td>
                {{$resultado->lugarDescarga}}
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
        <tr>
        </tr>
        <tr>
            <th style="font-weight:bold">Total descargado (Kg): {{$total}}</th>
            <th style="font-weight:bold">Total descargado con merma (Kg): {{$totalMerma}}</th>
        </tr>
        <tr></tr>
    </tbody>
</table>