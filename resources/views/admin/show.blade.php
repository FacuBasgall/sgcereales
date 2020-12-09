@extends('layout.master-admin')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label">
            Perfil de usuario</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="header-title" style="display:flex; justify-content: space-between;">
                    <div><b>Datos de {{auth()->user()->username}}
                        </b></div>
                    <div style="justify-content:end;"><a class="change-password"
                            href="{{ action('AdminController@form_password')}}"><b>Cambiar contraseña</b></a></div>
                </div>
                <hr>
                <div class="form-title">Contactos <a href="{{ action('AdminController@contact') }}"><button
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
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
