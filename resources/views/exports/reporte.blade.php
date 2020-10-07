<table>
    <div>Filtros aplicados</div>
    <thead>
        <tr>
            <th><strong>Fecha desde</strong></th>
            <th><strong>Fecha hasta</strong></th>
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
            <td>{{$filtros->fechaDesde}}</td>
            <td>{{$filtros->fechaHasta}}</td>
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
