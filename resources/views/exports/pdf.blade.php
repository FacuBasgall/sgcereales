<html>

<head>
    <style>
    @page {
        margin: 2cm 2cm;
        font-family: sans-serif;
    }

    body {
        font-family: sans-serif;
        font-size: 14px;
    }

    .entregador {
        font-family: sans-serif;
        font-size: 12px;
    }

    table {
        border-collapse: collapse;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: left;
    }


    .box {
        text-align: left;
        width: 100%
    }


    table,
    td,
    th {
        border: 1px solid black;
    }

    .footer {
        position: absolute;
        bottom: -65px;
        width: 100%;
        height: 40px;
    }

    .fecha {
        text-align: left;
    }

    .pagina {
        text-align: right;
    }
    </style>
</head>

<body class="container">
    <title>Nro Aviso: {{$aviso->nroAviso}}, {{$titular->nombre}}</title>
    <div class="box">
        <table>
            <tr>
                <th rowspan="6" colspan="6" class="entregador">
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
                    | {{$contacto->contacto}}
                    @endforeach
                </th>
                <th><strong>Nro Aviso:</strong></th>
                <td>{{ $aviso->nroAviso }}</td>
                <th><strong>Fecha:</strong></th>
                <td>{{date("d/m/Y", strtotime($aviso_entregador->fecha ))}}</td>
            </tr>
            <tr>
                <th><strong>Grano:</strong></th>
                <td>{{$producto->nombre}} {{$aviso_producto->tipo}}</td>
                <th><strong>Cosecha:</strong></th>
                <td>{{$aviso_producto->cosecha}}</td>
            </tr>
            <tr>
                <th><strong>Titular de C.P:</strong></th>
                <td>{{ $titular->nombre }}</td>
                <th><strong>Procedencia:</strong></th>
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
                <th><strong>Remitente Comercial:</strong></th>
                <td>{{ $remitente->nombre }}</td>
                <th><strong>Corredor:</strong></th>
                <td>{{ $corredor->nombre }}</td>
            </tr>
            <tr>
                <th><strong>Intermediario: </strong></th>
                @if (isset($intermediario->nombre))
                <td>{{$intermediario->nombre}}</td>
                @else <td>-</td>
                @endif
                <th><strong>Entregador: </strong></th>
                @if (isset($aviso->entregador))
                <td>{{$aviso->entregador}}</td>
                @else <td>-</td>
                @endif
            </tr>
            <tr>
                <th><strong>Destinatario:</strong></th>
                <td>{{ $destinatario->nombre }}</td>
                <th><strong>Destino o Unidad:</strong></th>
                <td>{{$aviso->lugarDescarga}}</td>
            </tr>
        </table>
    </div>
    <br>
    @php $totalDescargado = 0; $mermaTotal = 0 @endphp
    <div class="box" style="width: 100%;">
        <table>
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
            @php $totalDescargado = 0; $mermaTotal = 0 @endphp
            @foreach ($cargas as $carga)
            <tr>
                <td>{{$carga->matriculaCamion}}</td>
                <td>{{$carga->nroCartaPorte}}</td>
                <td>{{date("d/m/Y", strtotime($carga->fecha ))}}</td>
                <td>{{$carga->kilos}}</td>
                @foreach ($descargas as $descarga)
                @if($descarga->idCarga == $carga->idCarga)
                <td>{{date("d/m/Y", strtotime($descarga->fecha ))}}</td>
                <td>{{$descarga->bruto}}</td>
                <td>{{$descarga->tara}}</td>
                <td>{{$descarga->bruto - $descarga->tara}}</td>
                @php $totalDescargado += $descarga->bruto - $descarga->tara @endphp
                <td>{{$descarga->humedad}}</td>
                <td>{{$descarga->merma}}</td>
                <td>{{round(($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))}}</td>
                @php $mermaTotal += round(($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))
                @endphp
                <td>{{round(($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100)))}}
                </td>
                <td>{{round((($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))) - $carga->kilos)}}
                </td>
                <td>{{$descarga->ph}}</td>
                <td>{{$descarga->proteina}}</td>
                <td>{{$descarga->calidad}}</td>
                @endif
                @endforeach
            </tr>
            @endforeach
        </table>
    </div>
    <br>
    <div>
        <span colspan="3"><strong>Total descargado: </strong>{{$totalDescargado}}</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span colspan="2"><strong>Merma: </strong>{{$mermaTotal}}</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span><strong>Neto final: </strong>{{$totalDescargado - $mermaTotal}}</span>
        <br><br>
        <span colspan="5"><strong>Observaciones: </strong>{{$aviso->observacion}}</span>
    </div>
    <footer class="footer">
        @php $fecha = date("d/m/Y"); @endphp
        <div>
            <p class="fecha">{{$fecha}}</p>
        </div>
    </footer>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(400, 570, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    </script>
</body>

</html>
