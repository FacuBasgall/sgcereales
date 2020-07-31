@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
</head>

<body style="background-image:url(/image/corredor.jpg); no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Editar contactos de titular {{$titular->nombre}}</b></label>
    </div>
    <div class="container">
        <div class="card" style="min-height:450px;width:450px;">
            <h2>Informacion de Contacto</h2>
            <div class="box" style=" left:25px; top:50%">
                @if (!$titularContacto->isEmpty())
                @foreach ($tipoContacto as $tipo)
                @foreach ($titularContacto as $contacto)
                @if ($tipo->idTipoContacto == $contacto->tipo)
                <p><strong>{{$tipo->descripcion}}: </strong>{{$contacto->contacto}}
                    <a onclick="warningContact('{{$contacto->id}}', 'titular');"><button class="delete-button"
                            title="Eliminar" style="position: relative;"><i class="fa fa-trash"></i>
                            Eliminar</button></a></p>
                @endif
                @endforeach
                @endforeach
                @else
                <p>No se encontró información</p>
                @endif
                <form action="{{action('TitularController@add_contact', $titular->cuit)}}" method="GET">
                    {{ csrf_field() }}
                    <h6><strong>Agregar infomación de contacto:</strong></h6>
                    <label for="tipo">
                        <select name="tipo" class="input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($tipoContacto as $tipo)
                            <option value="{{$tipo->idTipoContacto}}">{{$tipo->descripcion}}</option>
                            @endforeach
                    </label>
                    <label for="contacto">
                        <input type="text" name="contacto" id="contacto" class="input" style="margin: 10px 20px;"
                            required>
                    </label>
                    <button type="submit" class="save-button" style="position:absolute; top:90%; left:70%;"><i
                            class="fa fa-check"></i> Guardar</button>
                </form>
                <a href="{{ action('TitularController@show', $titular->cuit)}}"><button class="back-button"
                        title="Volver" style="position: absolute; top:90%; right:70%;"><i class="fa fa-arrow-left"></i>
                        Salir</button></a>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
