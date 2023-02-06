<html>

<head>
    <style>
        @page {
            margin: 2cm 2cm;
            font-family: sans-serif;
        }

        body {
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
    <title>Resumen General de Avisos de Descargas</title>
    <div class="box">
        <table>
            <thead>
                <tr>
                    <th rowspan="3" colspan="5" valign="middle"><b>
                            {{$usuario->nombre}}<br>
                            {{$usuario->descripcion}}<br>
                            @foreach ($domicilio as $d)
                            {{$d->calle}}, {{$d->nombreLocalidad}} ({{$d->provinciaAbrev}} -
                            {{$d->cp}})<br>
                            @endforeach
                            @foreach ($contactos as $contacto)
                            | {{$contacto->contacto}} |
                            @endforeach
                        </b>
                    </th>
                    <th colspan="9">Resumen General de Avisos de Descargas</th>
                </tr>
                <tr>
                    <th colspan="9"><strong>Desde: </strong>{{date("d/m/Y", strtotime($fechadesde))}}</th>
                </tr>
                <tr>
                    <th colspan="9"><strong>Hasta: </strong>{{date("d/m/Y", strtotime($fechahasta))}}</th>
                </tr>
                <tr>
                    <th><strong>Número</strong></th>
                    <th><strong>Fecha</strong></th>
                    <th><strong>Entregador</strong></th>
                    <th><strong>Titular</strong></th>
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
                    @if ($aviso->entregadorNombre != NULL)
                    <td>
                        <div>{{$aviso->entregadorNombre}}</div>
                    </td>
                    @else
                    <td>
                        <div>{{$usuario->nombre}}</div>
                    </td>
                    @endif
                    <td>
                        <div>{{$aviso->titularNombre}}</div>
                    </td>
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
            </tbody>
            <br>

            <th colspan="7">Total descargado: {{$total}} Kg</th>
            <th colspan="7">Total descargado con merma: {{$totalMerma}} Kg</th>

        </table>

        <footer class="footer">
            @php $fecha = date("d/m/Y"); @endphp

            <p class="fecha">{{$fecha}} | Documento impreso desde Sistema Gestor de Cereales</p>

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