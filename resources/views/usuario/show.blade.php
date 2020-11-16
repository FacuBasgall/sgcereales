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
            <a>Gestión de usuario</a></label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="header-title" style="display:flex; justify-content: space-between;">
                    <div><b>Datos de {{auth()->user()->username}}
                        </b></div>
                    <div style="justify-content:end;"><a class="change-password"
                            href="{{ action('UsuarioController@form_password')}}"><b>Cambiar contraseña</b></a></div>
                </div>
                <hr>
                <div class="form-title">Datos generales <a href="{{ action('UsuarioController@edit')}}"><button
                            class="small-edit-button" title="Editar"><i class="fa fa-pencil"></i></button></a></div>
                <label class="labels"><strong>Nombre y Apellido: </strong>{{auth()->user()->nombre}}</label>
                <label class="labels"><strong>CUIT: </strong>{{auth()->user()->cuit}}</label>
                <br>
                <label class="labels"><strong>Descripción: </strong>{{auth()->user()->descripcion}}</label>
                <hr>
                <div class="form-title">Domicilios <a href="{{action('UsuarioController@domicile')}}"><button
                            class="small-edit-button" title="Gestionar direcciones"><i
                                class="fa fa-pencil"></i></button></a></div>
                @foreach($entregadorDomicilio as $domicilio)
                <label class="labels"><strong>País: </strong>{{$domicilio->pais}}</label>

                <label class="labels"><strong>Provincia: </strong>
                    @if (isset($domicilio->provincia))
                    @foreach($provincias as $provincia)
                    @if($domicilio->provincia == $provincia->id)
                    {{$provincia->nombre}}</label>
                @endif
                @endforeach
                @else
                <label class="info-text">-</label></label>
                @endif

                <label class="labels"><strong>Ciudad: </strong>
                    @if (isset($domicilio->localidad))
                    @foreach($localidades as $localidad)
                    @if($domicilio->localidad == $localidad->id)
                    {{$localidad->nombre}}</label>
                @endif
                @endforeach
                @else
                <label class="info-text">-</label></label>
                @endif

                <label class="labels"><strong>CP: </strong>
                    @if (isset($domicilio->cp))
                    {{$domicilio->cp}}</label>
                @else
                <label class="info-text">-</label></label>
                @endif

                <label class="labels"><strong>Dirección: </strong>{{$domicilio->domicilio}}</label>
                @endforeach
                <hr>
                <div class="form-title">Contactos <a href="{{ action('UsuarioController@contact') }}"><button
                            class="small-edit-button" title="Gestionar contactos"><i
                                class="fa fa-pencil"></i></button></a>
                </div>
                @if (!$entregadorContacto->isEmpty())
                @foreach ($tipoContacto as $tipo)
                @foreach ($entregadorContacto as $numero)
                @if ($tipo->idTipoContacto == $numero->tipo)
                <label class="labels"><strong>{{$tipo->descripcion}}: </strong>{{$numero->contacto}}</label>
                @endif
                @endforeach
                @endforeach
                @else
                <label class="labels info-text"><i class="fa fa-exclamation-circle"></i> No se encontraron
                    contactos</label>
                @endif
                <hr>
                <div class="form-title">Preferencias de email <a
                        href="{{ action('UsuarioController@edit_email_preferences') }}"><button
                            class="small-edit-button" title="Editar"><i class="fa fa-pencil"></i></button></a></div>
                <label class="labels"><strong>Correo: </strong>{{$correo->contacto}}</label><br>
                <label class="labels"><strong>Asunto: </strong>{{$preferencia->asunto}}</label><br>
                <label class="labels"><strong>Cuerpo: </strong>{{$preferencia->cuerpo}}</label>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
