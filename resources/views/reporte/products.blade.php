@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/general-reports.css') }}">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label">Reportes
            <i class="fa fa-chevron-right"></i> Resumen de productos entregados</label>
    </div>
    <div class="container">
        <div class="header-card">
            <form action="{{action('ReporteController@products')}}" method="GET">
                {{ csrf_field() }}
                <label for="fechaDesde">
                    <span>Fecha desde*:</span>
                    <input class="common-input" type="date" value="{{$fechaDesde}}" name="fechaDesde" id="fechaDesde" required>
                </label>
                <label for="fechaHasta">
                    <span>Fecha hasta*:</span>
                    <input class="common-input" type="date" value="{{$fechaHasta}}" name="fechaHasta" id="fechaHasta" required>
                </label>
                <div><label class="info-text-margin"><i class="fa fa-exclamation-circle"></i>
                        Los campos con * son obligatorios</label></div>
                <div class="center-of-page"><button type="submit" class="find-button"><i class="fa fa-search" aria-hidden="true"></i>
                        Buscar</button></div>

            </form>
        </div>
        <!-- Identify where the chart should be drawn. -->
        <div class="results-card">
            @if($control == 1)
            <div class="header-title">Resultados encontrados:</div>
            <div id="chart_div"></div>
            @elseif($control == 0)
            <label class="no-results">No se han encontrado resultados.</label>
            @elseif($control == 2)
            <label class="no-results">Realice una búsqueda para obtener resultados.</label>
            @endif
        </div>
    </div>
</body>

<script>
    var productos = <?php echo $productos; ?>;
    google.charts.load('current', {
        packages: ['corechart', 'bar'],
        'language': 'es'
    });
    google.charts.setOnLoadCallback(drawMaterial);

    function drawMaterial() {
        var data = google.visualization.arrayToDataTable(productos);

        /** 
         * Aplicar el NumberFormat a la segunda columna
         */
        var NumberFormat = new google.visualization.NumberFormat(
            {pattern:'##.###'}
        );
        NumberFormat.format(data, 1); 
        
        /** 
         * Aplicar el NumberFormat a la tercera columna
         */
        var NumberFormat2 = new google.visualization.NumberFormat(
            {pattern:'##.###'}
        );
        NumberFormat2.format(data, 2);

        var materialOptions = {
            chart: {
                title: 'Kg Descargados por Producto'
            },
            bars: 'vertical'
        };
        var materialChart = new google.charts.Bar(document.getElementById('chart_div'));
        materialChart.draw(data, materialOptions);
    }
</script>

@endsection