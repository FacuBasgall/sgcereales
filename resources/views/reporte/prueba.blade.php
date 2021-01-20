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
            <i class="fa fa-chevron-right"></i> Prueba</label>
    </div>
    <!-- Identify where the chart should be drawn. -->
    <div class="container">
        <div class="header-card">
            <div id="chart_div"></div>
        </div>
    </div>
</body>

<script>
    google.charts.load('current', {packages: ['corechart', 'bar'], 'language': 'es'});
    google.charts.setOnLoadCallback(drawMaterial);
    function drawMaterial() {
        var data = google.visualization.arrayToDataTable([
            ['Producto', 'Merma por manipuleo'],
            ['Trigo', 0.10], 
            ['Sorgo', 0.25], 
            ['Maiz', 0.25], 
            ['Soja', 0.25], 
            ['Girasol', 0.20], 
        ]);

        var materialOptions = {
            chart: {
            title: 'Merma de manipuleo por producto'
            },
            hAxis: {
            title: 'Merma manipuleo',
            minValue: 0,
            },
            vAxis: {
            title: 'Nombre'
            },
            bars: 'vertical'
        };
        var materialChart = new google.charts.Bar(document.getElementById('chart_div'));
        materialChart.draw(data, materialOptions);
        }    
</script>

@endsection
