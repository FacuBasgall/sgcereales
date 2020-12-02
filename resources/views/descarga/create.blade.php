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
                class="fa fa-chevron-right"></i> <a href="{{ action('AvisoController@show', $carga->idAviso)}}">Detalle
                del aviso</a> <i class="fa fa-chevron-right"></i> Añadir
            descarga</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <form action="{{action('DescargaController@store')}}" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    @php $hoy = date("Y-m-d") @endphp
                    <p class="form-title"><strong>Datos de la descarga</strong></p>
                    <label for="fecha">
                        <span>Fecha de descarga*:</span>
                        <input type="date" value="{{$hoy}}" name="fecha" id="fecha" class="common-input"
                            required>
                    </label>
                    <label for="bruto">
                        <span>Brutos (Kg)*:</span>
                        <input type="number" value="{{$carga->kilos}}" min="0" step="0.1" name="bruto" id="bruto"
                            class="common-input" onkeydown="noComa(event)" required>
                    </label>
                    <label for="tara">
                        <span>Tara (Kg)*:</span>
                        <input type="number" value="{{old('tara')}}" min="0" step="0.1" name="tara" id="tara"
                            class="common-input" onkeydown="noComa(event)" required>
                    </label>
                    <label for="humedad">
                        <span>Humedad (%)*:</span>
                        <input type="number" value="{{old('humedad')}}" step="0.1" min="0" max="30" name="humedad"
                            id="humedad" class="common-input-cp" onkeydown="noComa(event)" required>
                    </label>
                    <label for="ph">
                        <span>Ph: </span>
                        <input type="number" value="{{old('ph')}}" step="0.1" min="0" name="ph" id="ph"
                            class="common-input-cp" onkeydown="noComa(event)">
                    </label>
                    <label for="proteina">
                        <span>Proteína: </span>
                        <input type="number" value="{{old('proteina')}}" step="0.1" min="0" name="proteina"
                            id="proteina" class="common-input" onkeydown="noComa(event)">
                    </label>
                    <label for="calidad">
                        <span>Calidad: </span>
                        <input type="text" value="{{old('calidad')}}" name="calidad" list="calidad" class="common-input"
                            maxlength="150">
                        <datalist id="calidad">
                            @foreach ((array)$calidad as $c)
                            <option value="{{$c->calidad}}"></option>
                            @endforeach
                        </datalist>
                    </label>
                    <hr>
                    <div><label class="info-text-margin"><i class="fa fa-exclamation-circle"></i>
                            Los campos con * son obligatorios</label></div>
                    <input id="carga" name="carga" type="hidden" value="{{$carga->idCarga}}">
                    <div class="center-of-page"><button type="submit" class="save-button"><i class="fa fa-check"></i>
                            Guardar</button></div>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
