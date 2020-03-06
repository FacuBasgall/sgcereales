<html>
  <head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="{{ asset('ccs/login.css') }}" />
  </head>

<body id="LoginForm">
<div class="container">
<div class="login-form">
<div class="main-div">
<div class="panel">
   <h2>Sistema gestor de cereales</h2>
   <p>Por favor ingrese su usuario y contraseña</p>
</div>
    <form id="Login">
                    <form id="Login" method="POST" action="{{ route('login') }}">
                    @csrf
        <div class="form-group">
            <input type="email" class="form-control" id="inputEmail" placeholder="Email Address">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>

        <div class="form-group">
            <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                 @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                 @enderror
        </div>
        <div class="forgot">
            <a href="reset.html">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
    </form>
</div></div></div>


</body>
</html>
