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
        <label class="title col-md-8 col-form-label"><a href="{{ action('ReporteController@index')}}"> Reportes
                Generales </a><i class="fa fa-chevron-right"></i> Envio de email
        </label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="form-title" style="font-size:20px;"><b>Configuración envió de email</b></div>
                <form action="{{action('ReporteController@send_email')}}" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <label for="email">
                        <span>Correos*: </span>
                        <select name="email[]" id="email" class="common-input-long" multiple="multiple" required>
                            @foreach ($correos as $correo)
                            <option value="{{ $correo }}" {{old('email') == $correo ? 'selected':''}}>
                                {{ $correo }}
                            </option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#email").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                            tags: true,
                            tokenSeparators: [';', ' '],
                        });
                        </script>
                    </label>
                    <br>
                    <label for="asunto">
                        <span>Asunto*: </span>
                        <textarea name="asunto" id="asunto" class="textarea" value="{{old('asunto')}}" maxlength="200"
                            style="height:80px;" cols="150" required>Envió de Reporte general de descargas</textarea>
                    </label>
                    <br>
                    <label for="cuerpo">
                        <span>Cuerpo*: </span>
                        <textarea name="cuerpo" id="cuerpo" class="textarea" value="{{old('cuerpo')}}" maxlength="200"
                            style="height:80px;" cols="150"
                            required>Por favor no responder este correo. Comunicarse con {{$user_email->contacto}}</textarea>
                    </label>
                    <div><label class="info-text-margin"><i class="fa fa-exclamation-circle"></i>
                            Los campos con * son obligatorios</label></div>
                    <div class="center-of-page"><button type="submit" class="save-button" style="margin-top:13px;"><i class="fa fa-envelope"></i>
                            Enviar</button></div>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
