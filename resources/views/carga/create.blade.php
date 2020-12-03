@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-forms.css') }}">
    <script type="text/javascript" src="{{ asset('js/noComa.js') }}"></script>
</head>
<style>
:root {
    --color-green: #2f6fb3;
    --color-red: #aaa;
    --color-button: #ffffff;
    --color-black: #000;
}

.switchbutton {
    display: inline-block;
}

.switchbutton .switchbutton__checkbox {
    display: none;
}

.switchbutton .switchbutton__label {
    background-color: var(--color-red);
    width: 3.5rem;
    height: 1.5rem;
    border-radius: 3rem;
    display: inline-block;
    position: absolute;
}

.switchbutton .switchbutton__label:before {
    transition: .2s;
    display: block;
    position: absolute;
    width: 1.5rem;
    height: 1.5rem;
    background-color: var(--color-button);
    content: '';
    border-radius: 50%;
    box-shadow: inset 0px 0px 0px 1px var(--color-black);
}

.switchbutton .switchbutton__checkbox:checked+.switchbutton__label {
    background-color: var(--color-green);
}

.switchbutton .switchbutton__checkbox:checked+.switchbutton__label:before {
    transform: translateX(2rem);
}
</style>

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
                    @php $hoy = date("Y-m-d") @endphp
                    <p class="form-title"><strong>Datos de la carga</strong></p>
                    <label for="cartaPorte">
                        <span>Número carta porte*:</span>
                        <input type="number" value="{{old('cartaPorte')}}" name="cartaPorte" id="cartaPorte"
                            class="common-input" min="0" max="99999999999999999999" required>
                    </label>
                    <label for="fecha">
                        <span>Fecha de carga*:</span>
                        <input type="date" value="{{$hoy}}" name="fecha" id="fecha" class="common-input"
                            required>
                    </label>
                    <label for="matricula">
                        <span>Matrícula del camión:</span>
                        <input type="text" value="{{old('matricula')}}" name="matricula" id="matricula"
                            class="common-input" maxlength="7">
                    </label>
                    <label for="kilos">
                        <span>Cargado (Kg)*:</span>
                        <input type="number" value="{{old('kilos')}}" min="0" max="9999999999" step="0.1" name="kilos" id="kilos"
                            class="common-input" onkeydown="noComa(event)" required>
                    </label>
                    <hr>
                    <div><label class="info-text-margin"><i class="fa fa-exclamation-circle"></i>
                            Los campos con * son obligatorios</label></div>
                    <div class="switchbutton">
                        <!-- Checkbox -->
                        <input type="checkbox" name="switchbutton" id="switchlabel" class="switchbutton__checkbox" checked> <label for="switchlabel" class="switchbutton__label"></label>
                        <p style="margin-left:70px;">Deseo ingresar la descarga ahora</p>
                        <!-- Botón -->

                    </div>
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
