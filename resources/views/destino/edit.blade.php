@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select-pais.js') }}"></script>

</head>

<body style="background:url(/image/silo.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('DestinoController@index') }}">Destinatarios</a>
            / <a href="{{ action('DestinoController@show', $destino->cuit) }}">Detalle del destinatario</a> / Editar
            destinatario</label>
    </div>
    <div class="container">
        <div class="card" style="height:800px;width:450px;">
            <div class="box">
                <form action="{{action('DestinoController@update', $destino->cuit)}}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <label for="nombre">
                        <span>Nombre y apellido:*</span>
                        <input type="text" name="nombre" id="nombre" class="input" value="{{$destino->nombre}}"
                            style="margin: 10px 20px;" required>
                    </label>
                    <label for="cuit">
                        <span>CUIT: </span>
                        <input type="text" name="cuit" id="cuit" class="input" value="{{$destino->cuit}}"
                            style="margin: 10px 20px;" readonly>
                    </label>
                    <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" name="dgr" id="dgr" class="input" value="{{$destino->dgr}}"
                            style="margin: 10px 20px;">
                    </label>
                    <label for="iva">
                        <span>IVA:*</span>
                        <select name="iva" id="iva" class="input" required>
                            @foreach ($iva as $condicion)
                            @if($condicion->idCondIva == $destino->condIva)
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
                        <span>Pais: </span>
                        <select name="pais" id="pais" class="common-input" onChange="paisOnChange(this)">
                            @if($destino->pais == "Argentina")
                            <option value="Argentina" selected>Argentina</option>
                            <option value="Otro">Otro</option>
                            @elseif($destino->pais != "Argentina" && $destino->pais != NULL)
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
                            @if($provincia->id == $destino->provincia)
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
                            @if($localidad->id == $destino->localidad)
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
                        <span>Codigo postal: </span>
                        <input type="text" name="cp" id="cp" class="input" value="{{$destino->cp}}">
                    </label>
                    <label for="otroPais" id="otro" style="display:none;">
                        <span>Especifique: </span>
                        <input type="text" value="{{$destino->pais}}" name="otroPais" id="otroPais"
                            class="common-input">
                    </label>
                    <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" name="domicilio" id="domicilio" class="input" value="{{$destino->domicilio}}"
                            style="margin: 10px 20px;">
                    </label>
                    <button type="submit" class="save-button"><i class="fa fa-check"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection
