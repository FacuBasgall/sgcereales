@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/configurations.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label">Configuraciones
            <i class="fa fa-chevron-right"></i><a href="{{ action('UsuarioController@show')}}"> Gestión de usuario
            </a><i class="fa fa-chevron-right"></i> Cambiar contraseña</label>
    </div>
    <div class="container">
        <div class="card">
            <form method="POST" action="{{ action('UsuarioController@change_password') }}" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="passwordold">{{ __('Contraseña') }}</label>

                    <div>
                        <input id="passwordold" type="password" class="form-control @error('passwordold') is-invalid @enderror common-input" name="passwordold" required>

                        @error('passwordold')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password">{{ __('Nueva contraseña') }}</label>

                    <div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror common-input" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm">{{ __('Confirmar contraseña') }}</label>

                    <div>
                        <input id="password-confirm" type="password" class="form-control common-input" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div style="display:flex; justify-content:center;">
                    <button type="submit"  class="save-button">
                        {{ __('Guardar') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection