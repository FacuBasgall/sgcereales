<table>
    <thead>
        <tr>
            <th><strong>Nro Aviso</strong></th>
            <td>{{ $aviso->idAviso }}</td>
            <th><strong>Fecha</strong></th>
            <td>{{ $aviso_entregador->fecha }}</td>
        </tr>
        <tr>
            <th><strong>Grano</strong></th>
            <td>{{$producto->nombre}} {{$aviso_producto->tipo}}</td>
            <th><strong>Cosecha</strong></th>
            <td>{{$aviso_producto->cosecha}}</td>
        </tr>
        <tr>
            <th><strong>Titular de C.P.</strong></th>
            <td>{{ $titular->nombre }}</td>
            <th><strong>Procedencia</strong></th>
            <td>{{$aviso->localidadProcedencia}} ({{$aviso->provinciaProcedencia}})</td>
        </tr>
        <tr>
            <th><strong>Remitente Comercial</strong></th>
            <td>{{ $remitente->nombre }}</td>
            <th><strong>Corredor</strong></th>
            <td>{{ $corredor->nombre }}</td>
        </tr>
        @if (isset($intermediario->nombre))
            <tr>
                <th><strong>Intermediario: </strong></th>
                <td>{{$intermediario->nombre}}</td>
            </tr>
        @endif
        <tr>
            <th><strong>Destinatario</strong></th>
            <td>{{ $destinatario->nombre }}</td>
            <th><strong>Destino</strong></th>
            <td>{{$aviso->lugarDescarga}}</td>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="4"><strong>Carga</strong></th>
            <th colspan="12"><strong>Descarga</strong></th>
        </tr>
        <tr>
            <th>Matricula</th>
            <th>C.P.</th>
            <th>Fecha</th>
            <th>Kilos</th>
            <th>Fecha</th>
            <th>Bruto</th>
            <th>Tara</th>
            <th>Neto</th>
            <th>Humedad</th>
            <th>Merma (%)</th>
            <th>Merma (Kg.)</th>
            <th>Neto Final</th>
            <th>Diferencia</th>
            <th>P.H.</th>
            <th>Proteínas</th>
            <th>Calidad</th>
        </tr>
    </thead>
    <tbody>
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
                        <td>{{$descarga->humedad}}</td>
                        <td>{{$descarga->merma}}</td>
                        <td>{{round(($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))}}</td>
                        <td>{{round(($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100)))}}</td>
                        <td>{{round((($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))) - $carga->kilos)}}</td>
                        <td>{{$descarga->ph}}</td>
                        <td>{{$descarga->proteina}}</td>
                        <td>{{$descarga->calidad}}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
