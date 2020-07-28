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
        <label class="title col-md-8 col-form-label"><b>Crear aviso / Datos de carga</b></label>
    </div>
    <div class="container">
        <div class="card" style="min-height:470px; width:460px;">
            <div class="box">
                <form action="{{action('CargaController@store')}}" method="POST">
                    {{ csrf_field() }}
                    <label for="cartaPorte">
                        <span>N° Carta Porte:</span>
                        <input type="number" value="{{old('cartaPorte')}}" name="cartaPorte" id="cartaPorte"
                            class="input" style="margin: 10px 20px;">
                    </label>
                    <label for="fecha">
                        <span>Fecha de Carga:*</span>
                        <input type="date" value="{{old('fecha')}}" name="fecha" id="fecha" class="input"
                            style="margin: 10px 20px;" required>
                    </label>
                    <label for="matricula">
                        <span>Matricula del Camión:</span>
                        <input type="text" value="{{old('matricula')}}" name="matricula" id="matricula" class="input"
                            style="margin: 10px 20px;">
                    </label>
                    <label for="kilos">
                        <span>Kilos Cargados:*</span>
                        <input type="number" value="{{old('kilos')}}" min="0" name="kilos" id="kilos" class="input"
                            style="margin: 10px 20px;" required>
                    </label>
                    <label for="check">
                        <input type="checkbox" name="check" id="check" value="Descarga" checked> Deseo ingresar la
                        descarga ahora
                    </label>
                    <input type="hidden" name="idAviso" id="idAviso" value="{{$aviso->idAviso}}">
                    <button type="submit" class="save-button" style="position:relative; left:30%;"><i
                            class="fa fa-check"></i> Guardar</button>
                    <a href="{{ action('AvisoController@index') }}"><button type="button" class="back-button"
                            title="Volver" style="position: relative; right: 30%;"><i class="fa fa-arrow-left"></i>
                            Salir</button></a>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
