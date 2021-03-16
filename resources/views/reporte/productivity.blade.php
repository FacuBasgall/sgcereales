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
            <i class="fa fa-chevron-right"></i> Productividad por mes</label>
    </div>
    <div class="container">
        <div class="header-card">
            <form action="{{action('ReporteController@productivity')}}" method="GET">
                {{ csrf_field() }}
                <label for="anio">
                    <span>Año*:</span>
                    <select name="anio" id="labelanio" class="common-input" required>
                        <option value="" selected disabled hidden></option>
                        @foreach ($aniosSelect as $year)
                        <option value="{{ $year->anio }}" {{old('year') == $year->anio ? 'selected':''}}>
                            {{$year->anio}}
                        </option>
                        @endforeach
                    </select>
                    <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#labelanio").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                            allowClear: true
                        });
                    </script>
                </label>
                <div><label class="info-text-margin"><i class="fa fa-exclamation-circle"></i>
                        Los campos con * son obligatorios</label></div>
                <div class="center-of-page"><button type="submit" class="find-button"><i class="fa fa-search" aria-hidden="true"></i>
                        Buscar</button></div>

            </form>
        </div>
        <div class="results-card">
            @if($control == 1)
            <div class="header-title">Resultados encontrados:</div>
            <div id="curve_chart"></div>
            @elseif($control == 0)
            <label class="no-results">Realice una búsqueda para obtener resultados.</label>
            @endif
        </div>
    </div>
</body>

<script>
    var productividad = <?php echo $productividad; ?>;

    google.charts.load('current', {
        'packages': ['corechart'],
        'language': 'es'
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(productividad);

        var options = {
            title: 'Cantidad de Romaneos terminados por meses',
            legend: {
                position: 'top'
            },
            vAxis: { 
                format: '###', 
                title: 'Cantidad (unidad)',
            },
            hAxis: {  
                title: 'Meses',
            },
        };
        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
    }
</script>

@endsection