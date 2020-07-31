@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
</head>

<body style="background-image:url(/image/corredor.jpg); no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Añadir remitente</b></label>
    </div>
    <div class="container">
        <div class="card" style="min-height:300px; width:450px;">
            <div class="box">
                <form action="{{action('RemitenteController@store')}}" method="POST">
                    {{ csrf_field() }}
                    <label for="nombre">
                        <span>Nombre y Apellido:*</span>
                        <input type="text" value="{{old('nombre')}}" name="nombre" id="nombre" class="input"
                            style="margin: 10px 20px;" required>
                    </label>
                    <label for="cuit">
                        <span>CUIT:*</span>
                        <input type="text" value="{{old('cuit')}}" name="cuit" id="cuit" class="input"
                            style="margin: 10px 20px;" step="0.01" required>
                    </label>
                    <button type="submit" class="save-button" style="position:absolute; top:90%; left:70%;"><i
                            class="fa fa-check"></i> Guardar</button>
                    <a href="{{ action('RemitenteController@index') }}"><button type="button" class="back-button"
                            title="Volver" style="position: absolute; top: 90%; right: 70%;"><i
                                class="fa fa-arrow-left"></i>Volver</button></a>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
