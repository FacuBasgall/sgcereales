@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-forms.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label">Configuraciones
            <i class="fa fa-chevron-right"></i><a href="{{ action('UsuarioController@show')}}"> Gestión de usuario
            </a><i class="fa fa-chevron-right"></i> Preferencias de email</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="form-title" style="font-size:20px;"><b>Preferencias de email</b><i
                        class="fa fa-question-circle"
                        title="Variable de entorno que serán reemplazadas"
                        style="left: 100px; position: relative;"></i></div>
                <form action="{{action('UsuarioController@store_email_preferences')}}" method="POST" autocomplete="off">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <label for="email">
                        <span>Correo*: </span>
                        <select name="email" id="email" class="common-input-address" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($entregadorContacto as $correos)
                            <option value="{{ $correos->id }}" {{old('email') == $correos->contacto ? 'selected':''}}>
                                {{ $correos->contacto }}
                            </option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#email").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <br>
                    <label for="asunto">
                        <span>Asunto*: </span>
                        <textarea name="asunto" id="asunto" class="textarea" value="{{$preferencia->asunto}}"
                            maxlength="200" style="height:80px;" cols="150" required>{{$preferencia->asunto}}</textarea>
                    </label>
                    <br>
                    <label for="cuerpo">
                        <span>Cuerpo*: </span>
                        <textarea name="cuerpo" id="cuerpo" class="textarea" value="{{$preferencia->cuerpo}}"
                            maxlength="200" style="height:80px;" cols="150" required>{{$preferencia->cuerpo}}</textarea>
                    </label>
                    <div class="center-of-page"><button type="submit" class="save-button" style="margin-top:13px;"><i
                                class="fa fa-check"></i>
                            Guardar</button></div>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
