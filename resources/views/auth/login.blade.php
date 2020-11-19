@extends('layouts.app')

@section('content')

<body>
    <div class="container" style="margin-top: 40px; font-family: sans-serif;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="border-radius:3%;">
                    <div style="margin-top:30px; margin-bottom:15px;">
                        <div style="display:flex; justify-content:center; align-items:center;">
                            <img style="border-radius:50%; width:80px;" src="{{ URL::to('/image/SGC.jpg') }}">
                        </div>
                        <div style="display:flex; justify-content:center; align-items:center; text-align:center; font-size:30px;">
                            <span><b>Bienvenido<br>
                                    Sistema Gestor de Cereales</b></span>
                        </div>

                    </div>
                    <div class="card-body">
                        <div>
                            <form method="POST" action="{{ action('Auth\LoginController@authenticate') }}">
                                {{ csrf_field() }}
                                @if ($errors->any())
                                <p class="alert alert-danger">El nombre de usuario o contraseña son incorrectos</p>
                                @endif
                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de usuario') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    </div>
                                </div>
                        </div>
                        <a class="btn btn-link" style="display:flex; justify-content:center; align-items:center;" href="{{action ('Auth\ForgotPasswordController@showLinkRequestForm')}}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        <div>
                            <div style="display:flex; justify-content:center; align-items:center;">
                                <button type="submit" class="btn btn-primary" style="margin-top:10px;">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
@endsection
