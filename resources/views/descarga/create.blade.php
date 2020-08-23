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
        <label class="title col-md-8 col-form-label"><b>Crear aviso / Datos de descarga</b></label>
    </div>
    <div class="container">
        <div class="card" style="min-height:600px; width:460px;">
            <div class="box">
                <form action="{{action('DescargaController@store')}}" method="POST">
                    {{ csrf_field() }}
                    <label for="fecha">
                        <span>Fecha de la Descarga:*</span>
                        <input type="date" value="{{old('fecha')}}" name="fecha" id="fecha" class="input" style="margin: 10px 20px;" required>
                    </label>
                    <label for="bruto">
                        <span>Kilos Brutos:*</span>
                        <input type="number" value="{{old('bruto')}}" min="0" name="bruto" id="bruto" class="input" style="margin: 10px 20px;"
                            required>
                    </label>
                    <label for="tara">
                        <span>Tara Kg:*</span>
                        <input type="number" value="{{old('tara')}}" min="0" name="tara" id="tara" class="input" style="margin: 10px 20px;"
                            required>
                    </label>
                    <label for="humedad">
                        <span>Humedad (%):*</span>
                        <input type="number" value="{{old('humedad')}}" step=".1" min="0" name="humedad" id="humedad" class="input"
                            style="margin: 10px 20px;" required>
                    </label>
                    <label for="ph">
                        <span>Ph: </span>
                        <input type="number" value="{{old('ph')}}" step=".1" min="0" name="ph" id="ph" class="input"
                            style="margin: 10px 20px;">
                    </label>
                    <label for="proteina">
                        <span>Proteina: </span>
                        <input type="number" value="{{old('proteina')}}" step=".1" min="0" name="proteina" id="proteina" class="input"
                            style="margin: 10px 20px;">
                    </label>
                    <label for="calidad">
                        <span>Calidad: </span>
                        <input type="text" value="{{old('calidad')}}" name="calidad" id="calidad" class="input" style="margin: 10px 20px;">
                    </label>
                    <input id="carga" name="carga" type="hidden" value="{{$carga->idCarga}}">
                    <button type="submit" class="save-button" style="position:relative; left:35%;"><i
                            class="fa fa-check"></i> Guardar</button>
                    <a href="{{ action('AvisoController@index') }}"><button type="button" class="back-button"
                            title="Salir" style="position: relative; right: 40%;"><i
                                class="fa fa-arrow-left"></i> Salir</button></a>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
