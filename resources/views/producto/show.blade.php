@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('ProductoController@index') }}">Productos</a> <i
                class="fa fa-chevron-right"></i>
            Detalle del producto</label>
    </div>
    <div class="container center-of-page">
        <div class="card">
            <div class="box">
                <div class="header">
                    <span style="font-size: 24px;" class="header-title"><strong>{{$producto->nombre}}</strong></span>
                    <hr>
                    </hr>
                </div>
                <labels><strong>Merma por manipuleo: </strong>{{$producto->mermaManipuleo}}</labels>
                <br>
                <labels><strong>Tabla de merma por secado: </strong></labels>
            <div id="div1">
                <table>
                    <tr>
                        <th>Humedad</th>
                        <th>Merma</th>
                    </tr>
                    @foreach ($mermas as $merma)
                    <tr>
                        <td>{{$merma->humedad}}</td>
                        <td>{{$merma->merma}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            </div>
        </div>
    </div>
</body>
@endsection
