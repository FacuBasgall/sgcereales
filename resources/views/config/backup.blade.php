@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a>Configuraciones</a> <i class="fa fa-chevron-right"></i>
            <a>Copia de resguardo</a></label>
    </div>
    <br>
    <a href="{{ action('ConfigController@run_backup') }}"><button class="export-button"><i class="fa fa-floppy-o"></i>
            Guardar</button></a>
</body>
@endsection
