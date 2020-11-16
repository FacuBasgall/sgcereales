@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-forms.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label">Configuraciones
            <i class="fa fa-chevron-right"></i><a href="{{ action('UsuarioController@show')}}"> Gestión de usuario
            </a><i class="fa fa-chevron-right"></i> Editar datos de usuario</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="form-title" style="font-size:20px;"><b>Datos generales</b></div>
                <form action="{{action('UsuarioController@update')}}" method="POST" autocomplete="off">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <label for="nombre">
                        <span>Nombre y apellido*:</span>
                        <input type="text" name="nombre" id="nombre" class="common-input-address" value="{{auth()->user()->nombre}}" maxlength="200" required>
                    </label>
                    <label for="cuit">
                        <span>CUIT: </span>
                        <input type="number" name="cuit" id="cuit" class="common-input" value="{{auth()->user()->cuit}}" readonly>
                    </label>
                    <br>
                    <label for="descripcion">
                        <p class="form-title">Descripción*:</p>
                        <textarea name="descripcion" id="descripcion" value="{{auth()->user()->descripcion}}" class="textarea" style="height:80px;" placeholder="Ingrese una descripcion" cols="150">{{auth()->user()->descripcion}}</textarea>
                    </label>
                    <div class="center-of-page"><button type="submit" class="save-button" style="margin-top:13px;"><i class="fa fa-check"></i>
                            Guardar</button></div>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
