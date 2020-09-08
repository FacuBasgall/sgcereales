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
            / Añadir destinatario</label>
    </div>
    <div class="container">
        <div class="card" style="height:800px;width:450px;">
            <div class="box">
                <form action="{{action('DestinoController@store')}}" method="POST">
                    {{ csrf_field() }}
                    <label for="nombre">
                        <span>Nombre y apellido:*</span>
                        <input type="text" value="{{old('nombre')}}" name="nombre" id="nombre" class="input"
                            style="margin: 10px 20px;" required>
                    </label>
                    <label for="cuit">
                        <span>CUIT:*</span>
                        <input type="number" value="{{old('cuit')}}" name="cuit" id="cuit" class="input"
                            style="margin: 10px 20px;" min="0" max="99999999999" required>
                    </label>
                    <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" value="{{old('dgr')}}" name="dgr" id="dgr" class="input"
                            style="margin: 10px 20px;">
                    </label>
                    <label for="iva">
                        <span>IVA:*</span>
                        <select name="iva" id="iva" class="input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($iva as $condicion)
                            <option value="{{ $condicion->idCondIva }}"
                                {{old('iva') == $condicion->idCondIva ? 'selected':''}}>{{ $condicion->descripcion }}
                            </option>
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
                            <option value="Argentina" selected>Argentina</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </label>
                    <label for="provincia" class="margin-right" id="prov" style="display:;">
                        <span>Provincia:</span>
                        <select name="provincia" id="provincia" class="input">
                            <option value="" selected disabled hidden></option>
                            @foreach ($provincias as $provincia)
                            <option value="{{ $provincia->id }}" {{old('provincia') == $provincia->id ? 'selected':''}}>
                                {{$provincia->nombre}}</option>
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
                        <select name="localidad" id="localidad" class="input">
                            <option value="" selected disabled hidden></option>
                            @foreach ($localidades as $localidad)
                            <option value="{{ $localidad->id }}" {{old('localidad') == $localidad->id ? 'selected':''}}>
                                {{$localidad->nombre}}</option>
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
                        <input type="text" value="{{old('cp')}}" name="cp" id="cp" class="common-input-cp">
                    </label>
                    <label for="otroPais" id="otro" style="display:none;">
                        <span>Especifique: </span>
                        <input type="text" value="{{old('otroPais')}}" name="otroPais" id="otroPais"
                            class="common-input">
                    </label>
                    <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" value="{{old('domicilio')}}" name="domicilio" id="domicilio" class="input"
                            style="margin: 10px 20px;">
                    </label>
                    <button type="submit" class="save-button" style="position:relative; top:65%; left:30%;"><i
                            class="fa fa-check"></i> Guardar</button>
                    <a href="{{ action('DestinoController@index') }}"><button type="button" class="back-button"
                            title="Volver" style="position: relative; right: 40%; margin-top:10px"><i
                                class="fa fa-arrow-left"></i> Volver</button></a>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
