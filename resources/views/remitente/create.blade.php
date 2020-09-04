@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
</head>

<body style="background:url(/image/cargador-camion.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('RemitenteController@index') }}">Remitentes
                Comercial</a> / Añadir Remitente Comercial</label>
    </div>
    <div class="container">
        <div class="card" style="height:800px;width:450px;">
            <div class="box">
                <form action="{{action('RemitenteController@store')}}" method="POST">
                    {{ csrf_field() }}
                    <label for="nombre">
                        <span>Nombre y apellido:*</span>
                        <input type="text" value="{{old('nombre')}}" name="nombre" id="nombre" class="input" required>
                    </label>
                    <label for="cuit">
                        <span>CUIT:*</span>
                        <input type="text" value="{{old('cuit')}}" name="cuit" id="cuit" class="input" min="0"
                            max="999999999999999" required>
                    </label>
                    <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" value="{{old('dgr')}}" name="dgr" id="dgr" class="input">
                    </label>
                    <label for="iva">
                        <span>IVA:*</span>
                        <select name="iva" class="input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($iva as $condicion)
                            <option value="{{ $condicion->idCondIva }}"
                                {{old('iva') == $condicion->idCondIva ? 'selected':''}}>{{ $condicion->descripcion }}
                            </option>
                            @endforeach
                        </select>
                    </label>
                    <label for="cp">
                        <span>Codigo postal: </span>
                        <input type="text" value="{{old('cp')}}" name="cp" id="cp" class="input">
                    </label>
                    <label for="pais">
                        <span>Pais: </span>
                        <input type="text" value="Argentina" name="pais" id="pais" class="input">
                    </label>
                    <label for="provincia">
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
                        });
                        </script>
                    </label>
                    <label for="localidad">
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
                        });
                        </script>
                    </label>
                    <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" value="{{old('domicilio')}}" name="domicilio" id="domicilio" class="input">
                    </label>
                    <button type="submit" class="save-button" style="position:relative; left:40%; margin-top:10px"><i
                            class="fa fa-check"></i> Guardar</button>
                    <a href="{{ action('RemitenteController@index') }}"><button type="button" class="back-button"
                            title="Volver" style="position: relative; right: 40%; margin-top:10px"><i
                                class="fa fa-arrow-left"></i> Volver</button></a>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
