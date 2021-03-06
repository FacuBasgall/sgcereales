@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/contact-form.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label">Configuraciones
            <i class="fa fa-chevron-right"></i><a href="{{ action('UsuarioController@show')}}"> Perfil de usuario
            </a><i class="fa fa-chevron-right"></i> Gestión de contactos</label>
    </div>
    <div class="container">
        <div class="form-card">
            <span class="form-title"><strong>Añadir infomación de contacto</strong></span><br>
            <form action="{{action('UsuarioController@add_contact')}}" method="GET" autocomplete="off">
                {{ csrf_field() }}
                <label for="tipo">
                    <select name="tipo" class="common-input" required>
                        <option value="" selected hidden>Seleccione un tipo</option>
                        @foreach ($tipoContacto as $tipo)
                        <option value="{{$tipo->idTipoContacto}}" {{old('tipo') == $tipo->idTipoContacto ? 'selected':''}}>
                            {{$tipo->descripcion}}</option>
                        @endforeach
                </label>
                <label for="contacto">
                    <input type="text" placeholder="Ingrese el contacto" value="{{old('contacto')}}" name="contacto" id="contacto" class="common-input" required>
                </label>
                <button type="submit" class="save-button" style="padding:4px 12px;"><i class="fa fa-plus"></i>
                    Añadir</button>
            </form>
        </div>
        <div class="contacts-card">
            <div class="form-title"><strong>Gestión de contactos</strong></div>
            <div class="flex-elements">
                @if (!$entregadorContacto->isEmpty())
                @foreach ($tipoContacto as $tipo)
                @foreach ($entregadorContacto as $contacto)
                @if ($tipo->idTipoContacto == $contacto->tipo)
                <div class="margin-right"><strong>{{$tipo->descripcion}}: </strong>{{$contacto->contacto}} <a onclick="warningContact('{{$contacto->id}}', 'usuario');"><button class="small-delete-button" title="Eliminar"><i class="fa fa-trash"></i></button></a>
                </div>
                @endif
                @endforeach
                @endforeach
                @else
                <label class="labels info-text"><i class="fa fa-exclamation-circle"></i> No se encontraron contactos</label>
                @endif
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
