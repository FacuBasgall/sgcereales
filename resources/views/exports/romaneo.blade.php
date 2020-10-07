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
                </b></th>
            <th><b>Nro Aviso:</b></th>
            <td>{{ $aviso->nroAviso }}</td>
            <th><b>Fecha:</b></th>
            <td>{{ $aviso_entregador->fecha }}</td>
        </tr>
        <tr>
            <th style="font-weight:bold">Grano:</th>
            <td>{{$producto->nombre}} {{$aviso_producto->tipo}}</td>
            <th><b>Cosecha:</b></th>
            <td>{{$aviso_producto->cosecha}}</td>
        </tr>
        <tr>
            <th style="font-weight:bold">Titular de C.P:</th>
            <td>{{ $titular->nombre }}</td>
            <th><b>Procedencia:</b></th>
            @foreach($provincias as $provincia)
            @if($provincia->id == $aviso->provinciaProcedencia)
            @foreach($localidades as $localidad)
            @if($localidad->id == $aviso->localidadProcedencia)
            <td>{{$localidad->nombre}} ({{$provincia->abreviatura}})</td>
            @endif
            @endforeach
            @endif
            @endforeach
        </tr>
        <tr>
            <th style="font-weight:bold">Remitente Comercial:</th>
            <td>{{ $remitente->nombre }}</td>
            <th><b>Corredor:</b></th>
            <td>{{ $corredor->nombre }}</td>
        </tr>
        <tr>
            <th style="font-weight:bold">Intermediario:</th>
            @if (isset($intermediario->nombre))
            <td>{{$intermediario->nombre}}</td>
            @else <td>-</td>
            @endif
            <th><b>Entregador:</b></th>
            @if (isset($aviso->entregador))
            <td>{{$aviso->entregador}}</td>
            @else <td>-</td>
            @endif
        </tr>
        <tr>
            <th style="font-weight:bold">Destinatario:</th>
            <td>{{ $destinatario->nombre }}</td>
            <th><b>Destino o Unidad:</b></th>
            <td>{{$aviso->lugarDescarga}}</td>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="4"><b>Carga:</b></th>
            <th colspan="12"><b>Descarga:</b></th>
        </tr>
        <tr>
            <th><b>Matricula</b></th>
            <th><b>C.P.</b></th>
            <th><b>Fecha</b></th>
            <th><b>Kilos</b></th>
            <th><b>Fecha</b></th>
            <th><b>Bruto</b></th>
            <th><b>Tara</b></th>
            <th><b>Neto</b></th>
            <th><b>Humedad</b></th>
            <th><b>Merma (%)</b></th>
            <th><b>Merma (Kg.)</b></th>
            <th><b>Neto Final</b></th>
            <th><b>Diferencia</b></th>
            <th><b>P.H.</b></th>
            <th><b>Proteínas</b></th>
            <th><b>Calidad</b></th>
        </tr>
    </thead>
    <tbody>
        @php $totalDescargado = 0; $mermaTotal = 0 @endphp
        @foreach ($cargas as $carga)
        <tr>
            <td>{{$carga->matriculaCamion}}</td>
            <td>{{$carga->nroCartaPorte}}</td>
            <td>{{$carga->fecha}}</td>
            <td>{{$carga->kilos}}</td>
            @foreach ($descargas as $descarga)
            @if($descarga->idCarga == $carga->idCarga)
            <td>{{$descarga->fecha}}</td>
            <td>{{$descarga->bruto}}</td>
            <td>{{$descarga->tara}}</td>
            <td>{{$descarga->bruto - $descarga->tara}}</td>
            @php $totalDescargado += $descarga->bruto - $descarga->tara @endphp
            <td>{{$descarga->humedad}}</td>
            <td>{{$descarga->merma}}</td>
            <td>{{round(($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))}}</td>
            @php $mermaTotal += round(($descarga->bruto - $descarga->tara) * ($descarga->merma / 100)) @endphp
            <td>{{round(($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100)))}}</td>
            <td>{{round((($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))) - $carga->kilos)}}</td>
            <td>{{$descarga->ph}}</td>
            <td>{{$descarga->proteina}}</td>
            <td>{{$descarga->calidad}}</td>
            @endif
            @endforeach
        </tr>
        @endforeach
        <tr></tr>
        <tr>
            <th colspan="4"></th>
            <th colspan="3"><b>Total descargado: </b></th>
            <td>{{$totalDescargado}}</td>
            <th colspan="2"><b>Merma: </b></th>
            <td>{{$mermaTotal}}</td>
            <th><b>Neto final: </b></th>
            <td>{{$totalDescargado - $mermaTotal}}</td>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="4"><b>Observaciones: </b></th>
            <td>{{$aviso->observacion}}</td>
        </tr>
    </tbody>
</table>