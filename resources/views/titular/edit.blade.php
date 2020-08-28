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
        <label class="title col-md-8 col-form-label"><a href="{{ action('TitularController@index') }}">Titulares</a> /
            <a href="{{ action('TitularController@show', $titular->cuit) }}">Detalle del titular</a> / Editar
            titular</label>
    </div>
    <div class="container">
        <div class="card" style="height:800px;width:450px;">
            <div class="box">
                <form action="{{action('TitularController@update', $titular->cuit)}}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <label for="nombre">
                        <span>Nombre y apellido:*</span>
                        <input type="text" name="nombre" id="nombre" class="input" value="{{$titular->nombre}}"
                            required>
                    </label>
                    <label for="cuit">
                        <span>CUIT: </span>
                        <input type="text" name="cuit" id="cuit" class="input" value="{{$titular->cuit}}" readonly>
                    </label>
                    <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" name="dgr" id="dgr" class="input" value="{{$titular->dgr}}">
                    </label>
                    <label for="iva">
                        <span>IVA:*</span>
                        <select name="iva" class="input" required>
                            @foreach ($iva as $condicion)
                            @if($condicion->idCondIva == $titular->condIva)
                            <option value="{{$condicion->idCondIva}}" selected>{{ $condicion->descripcion }}</option>
                            @endif
                            <option value="{{ $condicion->idCondIva }}">{{ $condicion->descripcion }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label for="cp">
                        <span>Codigo postal: </span>
                        <input type="text" name="cp" id="cp" class="input" value="{{$titular->cp}}">
                    </label>
                    <label for="pais">
                        <span>Pais: </span>
                        <input type="text" name="pais" id="pais" class="input" value="{{$titular->pais}}">
                    </label>
                    <label for="provincia">
                        <span>Provincia:*</span>
                        <select name="provincia" id="provincia" class="input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($provincias as $provincia)
                            @if($provincia->id == $titular->provincia)
                            <option value="{{ $provincia->id }}" selected>{{ $provincia->nombre }}</option>
                            @else
                            <option value="{{ $provincia->id }}">{{$provincia->nombre}}</option>
                            @endif
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#provincia").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="localidad">
                        <span>Localidad:*</span>
                        <select name="localidad" id="localidad" class="input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($localidades as $localidad)
                            @if($localidad->id == $titular->localidad)
                            <option value="{{ $localidad->id }}" selected>{{ $localidad->nombre }}</option>
                            @else
                            <option value="{{ $localidad->id }}">{{$localidad->nombre}}</option>
                            @endif
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#localidad").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" name="domicilio" id="domicilio" class="input"
                            value="{{$titular->domicilio}}">
                    </label>
                    <button type="submit" class="save-button"><i class="fa fa-check"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
