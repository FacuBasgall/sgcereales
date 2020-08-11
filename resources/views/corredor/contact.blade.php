@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/contact-form.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
</head>

<body style="background-image:url(/image/corredor.jpg); no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Editar contactos de corredor {{$corredor->nombre}}</b></label>
    </div>
    <div class="container">
        <div class="card">
            <h2>Informacion de Contacto</h2>
            <div class="box" style="text-align:left; margin-left:60px;">
                @if (!$corredorContacto->isEmpty())
                @foreach ($tipoContacto as $tipo)
                @foreach ($corredorContacto as $contacto)
                @if ($tipo->idTipoContacto == $contacto->tipo)
                <p><strong>{{$tipo->descripcion}}: </strong>{{$contacto->contacto}}
                    <a onclick="warningContact('{{$contacto->id}}', 'corredor');"><button class="small-delete-button"
                            title="Eliminar"><i class="fa fa-trash"></i>
                            </button></a></p>
                @endif
                @endforeach
                @endforeach
                @else
                <p>No se encontró información</p>
                @endif
            </div>
            <div class="box">
                <form action="{{action('CorredorController@add_contact', $corredor->cuit)}}" method="GET">
                    {{ csrf_field() }}
                    <h6><strong>Agregar infomación de contacto:</strong></h6>
                    <label for="tipo">
                        <select name="tipo" class="input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($tipoContacto as $tipo)
                            <option value="{{$tipo->idTipoContacto}}"
                                {{old('tipo') == $tipo->idTipoContacto ? 'selected':''}}>
                                {{$tipo->descripcion}}</option>
                            @endforeach
                    </label>
                    <label for="contacto">
                        <input type="text" value="{{old('contacto')}}" name="contacto" id="contacto" class="input"
                            required>
                    </label>
                    <button type="submit" class="save-button" style="position:relative; left:110px; top:42px;"><i
                            class="fa fa-check"></i> Guardar</button>
                </form>
                <a href="{{ action('CorredorController@show', $corredor->cuit)}}"><button class="back-button"
                        title="Volver"  style="position:relative; right:110px; bottom:25px;"><i class="fa fa-arrow-left"></i>
                        Salir</button></a>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
