@extends('config.index')

@section('option')

<div class="content-title m-x-auto">
    <i class="fa fa-lock"></i> Cambiar contraseña
</div>

<form method="POST" action="{{ action('UsuarioController@change_password') }}" autocomplete="off">
    @csrf
    <div class="form-group row">
        <label for="passwordold" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

        <div class="col-md-6">
            <input id="passwordold" type="password" class="form-control @error('passwordold') is-invalid @enderror"
                name="passwordold" required>

            @error('passwordold')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nueva contraseña') }}</label>

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

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Guardar') }}
            </button>
        </div>
    </div>
</form>

@endsection
