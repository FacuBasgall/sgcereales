@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="background:url(/image/cargador-camion.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Editar intermediario</b></label>
    </div>
    <div class="container">
        <div class="card" style="height:800px;width:450px;">
            <div class="box">
                <form action="{{action('IntermediarioController@update', $intermediario->cuit)}}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <label for="nombre">
                        <span>Nombre y apellido:*</span>
                        <input type="text" name="nombre" id="nombre" class="input" value="{{$intermediario->nombre}}"
                            required>
                    </label>
                    <label for="cuit">
                        <span>CUIT: </span>
                        <input type="text" name="cuit" id="cuit" class="input" value="{{$intermediario->cuit}}" readonly>
                    </label>
                    <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" name="dgr" id="dgr" class="input" value="{{$intermediario->dgr}}">
                    </label>
                    <label for="iva">
                        <span>IVA:*</span>
                        <select name="iva" class="input" required>
                            @foreach ($iva as $condicion)
                            @if($condicion->idCondIva == $intermediario->condIva)
                            <option value="{{$condicion->idCondIva}}" selected>{{ $condicion->descripcion }}</option>
                            @endif
                            <option value="{{ $condicion->idCondIva }}">{{ $condicion->descripcion }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label for="cp">
                        <span>Codigo postal: </span>
                        <input type="text" name="cp" id="cp" class="input" value="{{$intermediario->cp}}">
                    </label>
                    <label for="pais">
                        <span>Pais: </span>
                        <input type="text" name="pais" id="pais" class="input" value="{{$intermediario->pais}}">
                    </label>
                    <label for="provincia">
                        <span>Provincia: </span>
                        <input type="text" name="provincia" id="provincia" class="input"
                            value="{{$intermediario->provincia}}">
                    </label>
                    <label for="localidad">
                        <span>Localidad: </span>
                        <input type="text" name="localidad" id="localidad" class="input"
                            value="{{$intermediario->localidad}}">
                    </label>
                    <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" name="domicilio" id="domicilio" class="input"
                            value="{{$intermediario->domicilio}}">
                    </label>
                    <button type="submit" class="save-button" style="position:relative; left:40%; margin-top:10px"><i
                            class="fa fa-check"></i> Guardar</button>
                    <a href="{{ action('IntermediarioController@show', $intermediario->cuit) }}"><button type="button"
                            class="back-button" title="Volver"
                            style="position: relative; right: 40%; margin-top:10px"><i class="fa fa-arrow-left"></i>
                            Volver</button></a>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
