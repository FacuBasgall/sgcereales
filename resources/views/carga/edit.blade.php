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
        <label class="title col-md-8 col-form-label"><b>Editar carga y descarga de aviso </b></label>
    </div>
    <a href="{{ action('AvisoController@index')}}"><button type="button" class="back-button"
            title="Salir"><i class="fa fa-arrow-left"></i> Salir</button></a>
    @foreach ($cargas as $carga)
    <div class="container">
        <div class="card grid-container" style="min-height:750px;width:950px;">
            <div class="column1">
                <span>Datos de la carga </span>
                <form action="{{action('CargaController@update', $carga->idCarga)}}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <label for="cartaPorte">
                        <span>Número de Carta Porte: </span>
                        <input type="text" name="cartaPorte" id="cartaPorte" value="{{$carga->nroCartaPorte}}"
                            class="input">
                    </label>
                    <label for="fecha">
                        <span>Fecha de Carga: *</span>
                        <input type="date" name="fecha" id="fecha" value="{{$carga->fecha}}" class="input""
                            required>
                    </label>
                    <label for=" matricula">
                        <span>Matricula del Camión: </span>
                        <input type="text" name="matricula" id="matricula" value="{{$carga->matriculaCamion}}"
                            class="input"">
                    </label>
                    <label for=" kilos">
                        <span>Kilos Cargados: *</span>
                        <input type="number" min="0" name="kilos" id="kilos" value="{{$carga->kilos}}" class="input""
                            required>
                    </label>
                    <button type=" submit" class="save-button" style="position:relative; top:65%; left:30%;"><i
                            class="fa fa-check"></i> Guardar</button>
                </form>
            </div>
            @foreach ($descargas as $descarga)
            @if ($descarga->idCarga == $carga->idCarga)
            <div class="column2">
                <span>Datos de la descarga</span>
                <form action="{{action('DescargaController@update', $descarga->idDescarga)}}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <label for="fecha">
                        <span>Fecha de la Descarga: *</span>
                        <input type="date" name="fecha" id="fecha" value="{{$descarga->fecha}}" class="input""
                            required>
                    </label>
                    <label for=" bruto">
                        <span>Kilos Brutos: *</span>
                        <input type="number" min="0" name="bruto" id="bruto" value="{{$descarga->bruto}}" class="input""
                            required>
                    </label>
                    <label for=" tara">
                        <span>Tara Kg: *</span>
                        <input type="number" min="0" name="tara" id="tara" value="{{$descarga->tara}}" class="input""
                            required>
                    </label>
                    <label for=" humedad">
                        <span>Humedad (%): *</span>
                        <input type="number" step=".1" min="0" name="humedad" id="humedad"
                            value="{{$descarga->humedad}}" class="input"" required>
                    </label>
                    <label for=" ph">
                        <span>Ph: </span>
                        <input type="number" step=".1" min="0" name="ph" id="ph" value="{{$descarga->ph}}" class="input""
                           >
                    </label>
                    <label for=" proteina">
                        <span>Proteina: </span>
                        <input type="number" step=".1" min="0" name="proteina" id="proteina"
                            value="{{$descarga->proteina}}" class="input"">
                    </label>
                    <label for=" calidad">
                        <span>Calidad: </span>
                        <input type="text" name="calidad" id="calidad" value="{{$descarga->calidad}}" class="input">
                    </label>
                    <input type="hidden" name="carga" id="carga" value="{{$carga->idCarga}}">
                    <button type="submit" class="save-button" style="position:relative; top:65%; left:30%;"><i
                            class="fa fa-check"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    @endforeach
    @include('sweet::alert')

</body>
@endsection
