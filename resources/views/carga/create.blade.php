@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-forms.css') }}">
    <script type="text/javascript" src="{{ asset('js/noComa.js') }}"></script>
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AvisoController@index')}}">Avisos</a> <i
                class="fa fa-chevron-right"></i> <a href="{{ action('AvisoController@show', $aviso->idAviso)}}">Detalle
                del aviso</a> <i class="fa fa-chevron-right"></i> Añadir
            carga</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <form action="{{action('CargaController@store')}}" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <p class="form-title"><strong>Datos de la carga</strong></p>
                    <label for="cartaPorte">
                        <span>Número carta porte*:</span>
                        <input type="number" value="{{old('cartaPorte')}}" name="cartaPorte" id="cartaPorte"
                            class="common-input" max="99999999999999999999" min="0" required>
                    </label>
                    <label for="fecha">
                        <span>Fecha de carga*:</span>
                        <input type="date" value="{{old('fecha')}}" name="fecha" id="fecha" class="common-input"
                            required>
                    </label>
                    <label for="matricula">
                        <span>Matrícula del camión:</span>
                        <input type="text" value="{{old('matricula')}}" name="matricula" id="matricula"
                            class="common-input" maxlength="7">
                    </label>
                    <label for="kilos">
                        <span>Cargado (Kg)*:</span>
                        <input type="number" value="{{old('kilos')}}" min="0" step="0.1" name="kilos" id="kilos"
                            class="common-input"  onkeydown="noComa(event)" required>
                    </label>
                    <hr>
                    <div><label class="info-text-margin"><i class="fa fa-exclamation-circle"></i>
                            Los campos con * son obligatorios</label></div>
                    <label for="check">
                        <input type="checkbox" name="check" id="check" value="Descarga" checked> Deseo ingresar la
                        descarga ahora
                    </label>
                    <input type="hidden" name="idAviso" id="idAviso" value="{{$aviso->idAviso}}">
                    <div class="center-of-page"><button type="submit" class="save-button"><i class="fa fa-check"></i>
                            Guardar</button></div>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
