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
            <i class="fa fa-chevron-right"></i><a href="{{ action('AdminController@show')}}"> Perfil de usuario
            </a><i class="fa fa-chevron-right"></i> Preferencias de email</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="form-title" style="font-size:20px;"><b>Preferencias de email</b></div>
                <form action="{{action('AdminController@store_email_preferences')}}" method="POST" autocomplete="off">
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
                    <div><label class="info-text-margin"><i class="fa fa-exclamation-circle"></i>
                            Los campos con * son obligatorios</label></div>
                    <div class="center-of-page"><button type="submit" class="save-button" style="margin-top:13px;"><i class="fa fa-check"></i>
                            Guardar</button></div>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
