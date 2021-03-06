<div class="container">
    <div class="row justify-content-center">
        <div>Solicitud de reestablecimiento de contraseña</div>
            <div>
                @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
                @endif
                <p>Hola, se solicitó un restablecimiento de contraseña para tu cuenta, haz clic en el botón que aparece a continuación para cambiar tu contraseña.
                Si tu no realizaste la solicitud de cambio de contraseña, solo ignora este mensaje.</p>
                <a href="{{ url('/password/reset/'.$token) }}">Haga clic aquí</a>
        </div>
    </div>
</div>
