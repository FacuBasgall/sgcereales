@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="background:url(/image/silo.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AvisoController@index')}}">Avisos</a> / <a
                href="{{ action('AvisoController@show', $aviso->idAviso)}}">Detalle del aviso</a> / Añadir
            carga</label>
    </div>
    <div class="container">
        <div class="card" style="min-height:470px; width:460px;">
            <div class="box">
                <form action="{{action('CargaController@store')}}" method="POST">
                    {{ csrf_field() }}
                    <label for="cartaPorte">
                        <span>Número carta porte:</span>
                        <input type="number" value="{{old('cartaPorte')}}" name="cartaPorte" id="cartaPorte"
                            class="input" style="margin: 10px 20px;">
                    </label>
                    <label for="fecha">
                        <span>Fecha de carga*:</span>
                        <input type="date" value="{{old('fecha')}}" name="fecha" id="fecha" class="input"
                            style="margin: 10px 20px;" required>
                    </label>
                    <label for="matricula">
                        <span>Matrícula del camión:</span>
                        <input type="text" value="{{old('matricula')}}" name="matricula" id="matricula" class="input"
                            style="margin: 10px 20px;">
                    </label>
                    <label for="kilos">
                        <span>Kilos cargados*:</span>
                        <input type="number" value="{{old('kilos')}}" min="0" name="kilos" id="kilos" class="input"
                            style="margin: 10px 20px;" required>
                    </label>
                    <label for="check">
                        <input type="checkbox" name="check" id="check" value="Descarga" checked> Deseo ingresar la
                        descarga ahora
                    </label>
                    <input type="hidden" name="idAviso" id="idAviso" value="{{$aviso->idAviso}}">
                    <button type="submit" class="save-button"><i class="fa fa-check"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
