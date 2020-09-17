@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-forms.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AvisoController@index')}}">Avisos</a> <i
                class="fa fa-chevron-right"></i> <a href="{{ action('AvisoController@show', $carga->idAviso)}}">Detalle
                del aviso</a> <i class="fa fa-chevron-right"></i> Editar carga y
            descarga</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <form action="{{action('CargaController@update')}}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <p class="form-title"><strong>Datos de la carga</strong></p>
                    <label for="cartaPorte">
                        <span>Número carta porte*:</span>
                        <input type="text" name="cartaPorte" id="cartaPorte" value="{{$carga->nroCartaPorte}}"
                            class="common-input" required>
                    </label>
                    <label for="fecha">
                        <span>Fecha de carga*:</span>
                        <input type="date" name="fecha" id="fecha" value="{{$carga->fecha}}" class="common-input"
                            required>
                    </label>
                    <label for="matricula">
                        <span>Matrícula del camión: </span>
                        <input type="text" name="matricula" id="matricula" value="{{$carga->matriculaCamion}}"
                            class="common-input">
                    </label>
                    <label for="kilos">
                        <span>Cargado (Kg)*:</span>
                        <input type="number" min="0" name="kilos" id="kilos" value="{{$carga->kilos}}"
                            class="common-input" required>
                    </label>
                    <input type="hidden" name="idCarga" id="idCarga" value="{{$carga->idCarga}}">
                    <hr>
            </div>
            @if (isset($descarga))
            <div class="box">
                <p class="form-title"><strong>Datos de la descarga</strong></p>
                <label for="fechaDescarga">
                    <span>Fecha de descarga*:</span>
                    <input type="date" name="fechaDescarga" id="fechaDescarga" value="{{$descarga->fecha}}"
                        class="common-input" required>
                </label>
                <label for="bruto">
                    <span>Bruto (Kg)*:</span>
                    <input type="number" min="0" name="bruto" id="bruto" value="{{$descarga->bruto}}"
                        class="common-input" required>
                </label>
                <label for="tara">
                    <span>Tara (Kg)*:</span>
                    <input type="number" min="0" name="tara" id="tara" value="{{$descarga->tara}}" class="common-input"
                        required>
                </label>
                <label for="humedad">
                    <span>Humedad (%)*:</span>
                    <input type="number" step=".1" min="0" name="humedad" id="humedad" value="{{$descarga->humedad}}"
                        class="common-input-cp" required>
                </label>
                <label for="ph">
                    <span>Ph: </span>
                    <input type="number" step=".1" min="0" name="ph" id="ph" value="{{$descarga->ph}}"
                        class="common-input-cp">
                </label>
                <label for="proteina">
                    <span>Proteína: </span>
                    <input type="number" step=".1" min="0" name="proteina" id="proteina" value="{{$descarga->proteina}}"
                        class="common-input">
                </label>
                <label for="calidad">
                    <span>Calidad: </span>
                    <input type="text" name="calidad" id="calidad" value="{{$descarga->calidad}}" class="common-input">
                </label>
            </div>
            @else
            <div>
                <p>No existe una descarga asociada</p>
            </div>
            @endif
            <hr>
            <div class="center-of-page"><button type="submit" class="save-button"><i class="fa fa-check"></i>
                    Guardar</button></div>
            </form>
        </div>
    </div>
    @include('sweet::alert')

</body>
@endsection
