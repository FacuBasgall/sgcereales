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
        <label class="title col-md-8 col-form-label"><a
                href="{{ action('IntermediarioController@index') }}">Intermediarios</a> <i
                class="fa fa-chevron-right"></i> Añadir intermediario</label>
    </div>
    <div class="container">
        <div class="card">
            <form action="{{action('IntermediarioController@store')}}" method="POST">
                {{ csrf_field() }}
                <p class="form-title"><strong>Datos del intermediario</strong></p>
                <label for="nombre">
                    <span>Nombre y apellido*:</span>
                    <input type="text" value="{{old('nombre')}}" name="nombre" id="nombre" class="common-input"
                        maxlength="200" required>
                </label>
                <label for="cuit">
                    <span>CUIT*:</span>
                    <input type="number" value="{{old('cuit')}}" name="cuit" id="cuit" class="common-input" min="0"
                        max="999999999999999" required>
                </label>
                <label for="dgr">
                    <span>DGR: </span>
                    <input type="text" value="{{old('dgr')}}" name="dgr" id="dgr" class="common-input" maxlength="20">
                </label>
                <label for="iva" class="margin-right">
                    <span>IVA*:</span>
                    <select name="iva" id="iva" class="common-input" required>
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
                <label for="pais" class="margin-right">
                    <span>País: </span>
                    <select name="pais" id="pais" class="common-input" onChange="paisOnChange(this)">
                        <option value="Argentina" selected>Argentina</option>
                        <option value="Otro">Otro</option>
                    </select>
                </label>
                <label for="provincia" class="margin-right" id="prov" style="display:;">
                    <span>Provincia:</span>
                    <select name="provincia" id="provincia" class="common-input">
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
                    <select name="localidad" id="localidad" class="common-input"></select>
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
                    <input type="number" value="{{old('cp')}}" name="cp" id="cp" max="9999" min="0" class="common-input-cp">
                </label>
                <label for="otroPais" id="otro" style="display:none;">
                    <span>Especifique: </span>
                    <input type="text" value="{{old('otroPais')}}" name="otroPais" id="otroPais" class="common-input" maxlength="100">
                </label>
                <label for="domicilio">
                    <span>Domicilio: </span>
                    <input type="text" value="{{old('domicilio')}}" name="domicilio" id="domicilio"
                        class="common-input-address" maxlength="250">
                </label>
                <hr>
                <div class="center-of-page"> <button type="submit" class="save-button"><i class="fa fa-check"></i>
                        Guardar</button> </div>
            </form>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
