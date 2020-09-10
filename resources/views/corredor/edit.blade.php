@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select-pais.js') }}"></script>

</head>

<body style="background:url(/image/cargador-camion.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('CorredorController@index') }}">Corredores</a> /
            <a href="{{ action('CorredorController@show', $corredor->cuit) }}">Detalle del corredor</a> / Editar
            corredor</label>
    </div>
    <div class="container">
        <div class="card" style="height:800px;width:450px;">
            <div class="box">
                <form action="{{action('CorredorController@update', $corredor->cuit)}}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <label for="nombre">
                        <span>Nombre y apellido*:</span>
                        <input type="text" name="nombre" id="nombre" class="input" value="{{$corredor->nombre}}"
                            required>
                    </label>
                    <label for="cuit">
                        <span>CUIT: </span>
                        <input type="text" name="cuit" id="cuit" class="input" value="{{$corredor->cuit}}" readonly>
                    </label>
                    <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" name="dgr" id="dgr" class="input" value="{{$corredor->dgr}}">
                    </label>
                    <label for="iva">
                        <span>IVA*:</span>
                        <select name="iva" id="iva" class="input" required>
                            @foreach ($iva as $condicion)
                            @if($condicion->idCondIva == $corredor->condIva)
                            <option value="{{$condicion->idCondIva}}" selected>{{ $condicion->descripcion }}</option>
                            @endif
                            <option value="{{ $condicion->idCondIva }}">{{ $condicion->descripcion }}</option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#iva").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="pais">
                        <span>País: </span>
                        <select name="pais" id="pais" class="common-input" onChange="paisOnChange(this)">
                            @if($corredor->pais == "Argentina")
                            <option value="Argentina" selected>Argentina</option>
                            <option value="Otro">Otro</option>
                            @elseif($corredor->pais != "Argentina" && $corredor->pais != NULL)
                            <option value="Argentina">Argentina</option>
                            <option value="Otro" selected>Otro</option>
                            @else
                            <option value="Argentina">Argentina</option>
                            <option value="Otro">Otro</option>
                            @endif
                        </select>
                    </label>
                    <label for="provincia" class="margin-right" id="prov" style="display:;">
                        <span>Provincia:</span>
                        <select name="provincia" id="provincia" class="input" >
                            <option value="" selected disabled hidden></option>
                            @foreach ($provincias as $provincia)
                            @if($provincia->id == $corredor->provincia)
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
                            allowClear: true
                        });
                        </script>
                    </label>
                    <label for="localidad" class="margin-right" id="loc" style="display:;">
                        <span>Localidad:</span>
                        <select name="localidad" id="localidad" class="input" >
                            <option value="" selected disabled hidden></option>
                            @foreach ($localidades as $localidad)
                            @if($localidad->id == $corredor->localidad)
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
                            allowClear: true
                        });
                        </script>
                    </label>
                    <label for="cp" id="cod" style="display:;">
                        <span>Código postal: </span>
                        <input type="text" name="cp" id="cp" class="input" value="{{$corredor->cp}}">
                    </label>
                    <label for="otroPais" id="otro" style="display:none;">
                        <span>Especifique: </span>
                        <input type="text" value="{{$corredor->pais}}" name="otroPais" id="otroPais"
                            class="common-input">
                    </label>
                    <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" name="domicilio" id="domicilio" class="input"
                            value="{{$corredor->domicilio}}">
                    </label>
                    <button type="submit" class="save-button"><i class="fa fa-check"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
