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
