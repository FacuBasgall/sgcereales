@extends('config.index')

@section('option')
<div class="content-title m-x-auto">
    <i class="fa fa-user-plus"></i> Crear usuario
</div>

<form method="POST" action="{{ action('UsuarioController@store') }}" autocomplete="off">
    @csrf

    <div class="form-group row">
        <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de usuario') }}</label>

        <div class="col-md-6">
            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                name="username" value="{{ old('username') }}" required autofocus>

            @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

        <div class="col-md-6">
            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm"
            class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña') }}</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">
        </div>
    </div>

    <hr>
    <span>Datos personales: </span>
    <div class="form-group row">
        <label for="cuit" class="col-md-4 col-form-label text-md-right">{{ __('CUIT') }}</label>

        <div class="col-md-6">
            <input id="cuit" type="number" min="0" max="999999999999999"
                class="form-control @error('cuit') is-invalid @enderror" name="cuit" value="{{ old('cuit') }}" required
                autofocus>

            @error('cuit')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre y apellido') }}</label>

        <div class="col-md-6">
            <input id="cuit" type="text" maxlength="200" class="form-control @error('nombre') is-invalid @enderror"
                name="nombre" value="{{ old('nombre') }}" required autofocus>

            @error('nombre')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>

        <div class="col-md-6">
            <input id="descripcion" type="text" maxlength="250"
                class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"
                value="{{ old('nombre') }}" placeholder="Entrega y Recibo de Cereales, Oleaginosas y Subproductos"
                required autofocus>

            @error('descripcion')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Guardar') }}
            </button>
        </div>
    </div>
</form>

@endsection
