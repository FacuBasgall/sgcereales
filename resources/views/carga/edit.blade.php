@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="background:url(/image/silo.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AvisoController@index')}}">Avisos</a> / <a
                href="{{ action('AvisoController@show', $carga->idAviso)}}">Detalle del aviso</a> / Editar carga y
            descarga</label>
    </div>
    <div class="container">
        <div class="card grid-container" style="min-height:650px;width:850px;">
            <div class="column1">
                <span>Datos de la carga </span>
                <form action="{{action('CargaController@update')}}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <label for="cartaPorte">
                        <span>Número de Carta Porte: </span>
                        <input type="text" name="cartaPorte" id="cartaPorte" value="{{$carga->nroCartaPorte}}"
                            class="edit-aviso-input">
                    </label>
                    <label for="fecha">
                        <span>Fecha de Carga:*</span>
                        <input type="date" name="fecha" id="fecha" value="{{$carga->fecha}}" class="edit-aviso-input"
                            required>
                    </label>
                    <label for="matricula">
                        <span>Matricula del Camión: </span>
                        <input type="text" name="matricula" id="matricula" value="{{$carga->matriculaCamion}}"
                            class="edit-aviso-input">
                    </label>
                    <label for="kilos">
                        <span>Kilos Cargados:*</span>
                        <input type="number" min="0" name="kilos" id="kilos" value="{{$carga->kilos}}"
                            class="edit-aviso-input" required>
                    </label>
                    <input type="hidden" name="idCarga" id="idCarga" value="{{$carga->idCarga}}">
                    <button type="submit" class="save-button"
                        style="position:absolute; bottom: 0; margin-bottom:20px;"><i class="fa fa-check"></i> Guardar
                    </button>
            </div>
            @if (isset($descarga))
            <div class="column2">
                <span>Datos de la descarga</span>
                <label for="fechaDescarga">
                    <span>Fecha de la Descarga:*</span>
                    <input type="date" name="fechaDescarga" id="fechaDescarga" value="{{$descarga->fecha}}" class="edit-aviso-input"
                        required>
                </label>
                <label for="bruto">
                    <span>Kilos Brutos:*</span>
                    <input type="number" min="0" name="bruto" id="bruto" value="{{$descarga->bruto}}"
                        class="edit-aviso-input" required>
                </label>
                <label for="tara">
                    <span>Tara Kg:*</span>
                    <input type="number" min="0" name="tara" id="tara" value="{{$descarga->tara}}"
                        class="edit-aviso-input" required>
                </label>
                <label for="humedad">
                    <span>Humedad (%):*</span>
                    <input type="number" step=".1" min="0" name="humedad" id="humedad" value="{{$descarga->humedad}}"
                        class="edit-aviso-input" required>
                </label>
                <label for="ph">
                    <span>Ph: </span>
                    <input type="number" step=".1" min="0" name="ph" id="ph" value="{{$descarga->ph}}"
                        class="edit-aviso-input">
                </label>
                <label for="proteina">
                    <span>Proteina: </span>
                    <input type="number" step=".1" min="0" name="proteina" id="proteina" value="{{$descarga->proteina}}"
                        class="edit-aviso-input">
                </label>
                <label for="calidad">
                    <span>Calidad: </span>
                    <input type="text" name="calidad" id="calidad" value="{{$descarga->calidad}}"
                        class="edit-aviso-input">
                </label>
            </div>
            @else
            <div>
                <p>No existe una descarga asociada</p>
            </div>
            @endif
            </form>
        </div>
    </div>
    @include('sweet::alert')

</body>
@endsection
