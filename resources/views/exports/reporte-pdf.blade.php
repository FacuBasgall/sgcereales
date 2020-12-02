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
                    <th rowspan="3" colspan="5" valign="middle"><b>
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
                    <th colspan="9">Resumen General de Descarga</th>
                </tr>
                <tr>
                    <th colspan="9"><strong>Desde: </strong>{{$filtros->fechaDesde}}</th>
                </tr>
                <tr>
                    <th colspan="9"><strong>Hasta: </strong>{{$filtros->fechaHasta}}</th>
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
                    <td>{{$resultado->tipo}}</td>
                    <td>{{$resultado->cosecha}}</td>
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
            </tbody>
            <br>

            <th colspan="7">Total descargado: {{$total}} Kg</th>
            <th colspan="7">Total descargado con merma: {{$totalMerma}} Kg</th>

        </table>

        <footer class="footer">
            @php $fecha = date("d/m/Y"); @endphp

            <p class="fecha">{{$fecha}}</p>

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