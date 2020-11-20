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
            <th><strong>Titular carta porte</strong></th>
            <th><strong>Intermediario</strong></th>
            <th><strong>Remitente comercial</strong></th>
            <th><strong>Corredor</strong></th>
            <th><strong>Destinatario</strong></th>
            <th><strong>Producto</strong></th>
            <th><strong>Entregador</strong></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @if(isset($filtros->idTitular))
            <td>{{$filtros->idTitular}}</td>
            @else
            <td>-</td>
            @endif
            @if(isset($filtros->idIntermediario))
            <td>{{$filtros->idIntermediario}}</td>
            @else
            <td>-</td>
            @endif
            @if(isset($filtros->idRemitente))
            <td>{{$filtros->idRemitente}}</td>
            @else
            <td>-</td>
            @endif
            @if(isset($filtros->idCorredor))
            <td>{{$filtros->idCorredor}}</td>
            @else
            <td>-</td>
            @endif
            @if(isset($filtros->idDestinatario))
            <td>{{$filtros->idDestinatario}}</td>
            @else
            <td>-</td>
            @endif
            @if(isset($filtros->idProducto))
            <td>{{$filtros->idProducto}}</td>
            @else
            <td>-</td>
            @endif
            @if(isset($filtros->entregador))
            <td>{{$filtros->entregador}}</td>
            @else
            <td>{{$entregador->nombre}}</td>
            @endif
        </tr>
    </tbody>
</table>
