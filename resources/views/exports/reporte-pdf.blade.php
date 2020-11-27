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
    <title>Reporte General de Descargas</title>
    <div class="box">
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
                    <th><strong>Desde</strong></th>
                    <td>{{$filtros->fechaDesde}}</td>
                </tr>
                <tr>
                    <th><strong>Hasta</strong></th>
                    <td>{{$filtros->fechaHasta}}</td>
                </tr>
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

                    @php
                    $descargado += $resultado->bruto - $resultado->tara;
                    $merma += round(($resultado->bruto - $resultado->tara) * ($resultado->merma / 100));
                    @endphp

                    <td>{{$descargado}}</td>
                    <td>{{$descargado - $merma}}</td>
                    @php $total += $descargado; $totalMerma += ($descargado - $merma); @endphp
                </tr>
                @endforeach
            </tbody>
            <br>
            <div>
                <th>Total descargado (Kg):</th>
                <td>{{$total}}</td>
                <th>Total descargado con merma (Kg):</th>
                <td>{{$totalMerma}}</td>
            </div>
        </table>
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
