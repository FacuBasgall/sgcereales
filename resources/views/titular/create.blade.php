@extends('layout.master')
@section('content')
@parent

<head>
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-forms.css') }}">
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
</head>

<body>
    <div>
        <label class="title col-md-8 col-form-label"><a href="{{ action('TitularController@index') }}">Titulares carta porte</a> /
            Añadir titular</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <form action="{{action('TitularController@store')}}" method="POST">
                    {{ csrf_field() }}
                    <p class="form-title"><strong>Datos del titular</strong></p>
                    <label for="nombre">
                        <span>Nombre y apellido:*</span>
                        <input type="text" value="{{old('nombre')}}" name="nombre" id="nombre" class="common-input" required>
                    </label>
                    <label for="cuit" >
                        <span>CUIT:*</span>
                        <input type="text" value="{{old('cuit')}}" name="cuit" id="cuit" class="common-input" min="0"
                            max="999999999999999" required>
                    </label>
                    <label for="dgr" >
                        <span>DGR: </span>
                        <input type="text" value="{{old('dgr')}}" name="dgr" id="dgr" class="common-input">
                    </label>
                    <label for="iva" >
                        <span>IVA:*</span>
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
                    <label for="pais">
                        <span>Pais: </span>
                        <input type="text" value="Argentina" name="pais" id="pais" class="common-input">
                    </label>
                    <label for="provincia" class="margin-right">
                        <span>Provincia:</span>
                        <select name="provincia" id="provincia" class="common-input" >
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
                    <label for="localidad" class="margin-right">
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
                    <label for="cp" >
                        <span>Codigo postal: </span>
                        <input type="text" value="{{old('cp')}}" name="cp" id="cp" class="common-input-cp">
                    </label>
                    <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" value="{{old('domicilio')}}" name="domicilio" id="domicilio" class="common-input-address">
                    </label>
                    <hr>
                    <div class="center-of-page"> <button type="submit" class="save-button"><i class="fa fa-check"></i> Guardar</button> </div>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
