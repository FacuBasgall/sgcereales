<table>
    <thead>
        <tr>
            <th rowspan="1" colspan="3"><b>Resumen General de Avisos de Descargas</b></th>
        </tr>
        <div>
            <tr>
                <th colspan="3">
                    <b>
                        {{$usuario->nombre}}
                    </b>
                </th>
                <th><b style="font-weight:bold">Fecha desde: {{date("d/m/Y", strtotime($fechadesde))}}</b></th>
            </tr>
            <tr>
                <th colspan="3">
                    <b>
                        {{$usuario->descripcion}}
                    </b>
                </th>
                <th><b style="font-weight:bold">Fecha hasta: {{date("d/m/Y", strtotime($fechahasta))}}</b></th>
            </tr>
            <tr>
                <th colspan="3">
                    <b>
                        @foreach ($domicilio as $d)
                        {{$d->calle}}, {{$d->nombreLocalidad}} ({{$d->provinciaAbrev}} -
                        {{$d->cp}})
                        @endforeach
                        @foreach ($contactos as $contacto)
                        | {{$contacto->contacto}} |
                        @endforeach
                    </b>
                <th>
            </tr>
        </div>
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
            <th><strong>Destino</strong></th>
            <th><strong>Neto (Kg)</strong></th>
            <th><strong>Neto merma (Kg)</strong></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; $totalMerma = 0; $descargado = 0; $merma = 0; @endphp
        @foreach ($avisos as $aviso)
        <tr>
            <td>{{ $aviso->nroAviso }}</td>
            <td>{{ $aviso->fecha }}</td>
            <td>
                <div>{{$aviso->titularNombre}}</div>
            </td>
            @if ($aviso->intermediarioNombre == NULL)
            <td>
                <div>-</div>
            </td>
            @else
            <td>
                <div>{{$aviso->intermediarioNombre}}</div>
            </td>
            @endif
            <td>
                <div>{{$aviso->remitenteNombre}}</div>
            </td>
            <td>
                <div>{{$aviso->corredorNombre}}</div>
            </td>
            <td>
                <div>{{$aviso->destinatarioNombre}}</div>
            </td>
            <td>
                <div>{{$aviso->productoNombre}}</div>
            </td>
            <td>
                <div>{{$aviso->lugarDescarga}}</div>
            </td>
            @php
            $descargado = round($aviso->bruto - $aviso->tara);
            $merma = round(($aviso->bruto - $aviso->tara) * ($aviso->merma / 100));
            $total += $descargado; $totalMerma += ($descargado - $merma);
            @endphp
            <td>{{$descargado}}</td>
            <td>{{($descargado - $merma)}}</td>
        </tr>
        @endforeach
        <tr>
        </tr>
        <tr>
            <th colspan="3" style="font-weight:bold">Total descargado (Kg): {{$total}}</th>
            <th colspan="3" style="font-weight:bold">Total descargado con merma (Kg): {{$totalMerma}}</th>
        </tr>
        <tr></tr>
    </tbody>
</table>