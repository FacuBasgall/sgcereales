@extends('layout.master-admin')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-forms.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AdminController@view_users') }}">Gestión de usuarios</a>
            <i class="fa fa-chevron-right"></i> Crear usuario</label>
    </div>
    <div class="container">
        <div class="card">
            <form method="POST" action="{{ action('AdminController@store') }}" autocomplete="off">
                {{ csrf_field() }}
                @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                <p class="form-title"><strong>Datos del usuario</strong></p>
                <label for="username">
                    <span>Nombre de usuario*:</span>
                    <input id="username" type="text" class="common-input @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username') }}" required autofocus>
                </label>
                <label for="email">
                    <span>Correo electrónico*:</span>
                    <input id="email" type="text" class="common-input-address @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus>
                </label>
                <label for="password">
                    <span>Contraseña*:</span>
                    <input id="password" type="password" class="common-input @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">
                </label>
                <label for="password-confirm">
                    <span>Confirmar contraseña*:</span>
                    <input id="password-confirm" type="password" class="common-input" name="password_confirmation"
                        required autocomplete="new-password">
                </label>
                <hr>
                <p class="form-title"><strong>Datos personales</strong></p>
                <label for="cuit">
                    <span>CUIT*:</span>
                    <input id="cuit" type="number" min="0" max="999999999999999"
                        class="common-input @error('cuit') is-invalid @enderror" name="cuit" value="{{ old('cuit') }}"
                        required autofocus>
                </label>
                <label for="nombre">
                    <span>Nombre y Apellido*:</span>
                    <input id="nombre" type="text" maxlength="200"
                        class="common-input @error('nombre') is-invalid @enderror" name="nombre"
                        value="{{ old('nombre') }}" required autofocus>
                </label>
                <br><br>
                <label for="descripcion">
                    <span>Descripcion*:</span>
                    <textarea id="descripcion" maxlength="250"
                        class="observation-box @error('descripcion') is-invalid @enderror" name="descripcion"
                        value="{{ old('descripcion') }}" style="height:80px;" cols="150" required
                        autofocus>Entrega y Recibo de Cereales, Oleaginosas y Subproductos</textarea>
                </label>
                <hr>
                <div><label class="info-text-margin"><i class="fa fa-exclamation-circle"></i>
                        Los campos con * son obligatorios</label></div>
                <div class="center-of-page"> <button type="submit" class="save-button"><i class="fa fa-check"></i>
                        Guardar</button> </div>
            </form>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
