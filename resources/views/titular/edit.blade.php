@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-forms.css') }}">
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select-pais.js') }}"></script>

</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('TitularController@index') }}">Titulares</a> /
            <a href="{{ action('TitularController@show', $titular->cuit) }}">Detalle del titular</a> / Editar
            Titular</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <form action="{{action('TitularController@update', $titular->cuit)}}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <p class="form-title"><strong>Datos del titular</strong></p>
                    <label for="nombre">
                        <span>Nombre y apellido:*</span>
                        <input type="text" name="nombre" id="nombre" class="common-input" value="{{$titular->nombre}}"
                            required>
                    </label>
                    <label for="cuit">
                        <span>CUIT: </span>
                        <input type="text" name="cuit" id="cuit" class="common-input" value="{{$titular->cuit}}" readonly>
                    </label>
                    <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" name="dgr" id="dgr" class="common-input" value="{{$titular->dgr}}">
                    </label>
                    <label for="iva" class="margin-right">
                        <span>IVA:*</span>
                        <select name="iva" id="iva" class="common-input" required>
                            @foreach ($iva as $condicion)
                            @if($condicion->idCondIva == $titular->condIva)
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
                            @if($titular->pais == "Argentina")
                            <option value="Argentina" selected>Argentina</option>
                            <option value="Otro">Otro</option>
                            @elseif($titular->pais != "Argentina" && $titular->pais != NULL)
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
                        <select name="provincia" id="provincia" class="common-input" >
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
                            allowClear: true
                        });
                        </script>
                    </label>
                    <label for="localidad" class="margin-right" id="loc" style="display:;">
                        <span>Localidad:</span>
                        <select name="localidad" id="localidad" class="common-input" >
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
                            allowClear: true
                        });
                        </script>
                    </label>
                    <label for="cp" id="cod" style="display:;">
                        <span>Código postal: </span>
                        <input type="text" name="cp" id="cp" class="common-input-cp" value="{{$titular->cp}}">
                    </label>
                    <label for="otroPais" id="otro" style="display:none;">
                        <span>Especifique: </span>
                        <input type="text" value="{{$titular->pais}}" name="otroPais" id="otroPais"
                            class="common-input">
                    </label>
                    <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" name="domicilio" id="domicilio" class="common-input-address"
                            value="{{$titular->domicilio}}">
                    </label>
                    <hr>
                    <div class="center-of-page"><button type="submit" class="save-button"><i class="fa fa-check"></i> Guardar</button></div>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
