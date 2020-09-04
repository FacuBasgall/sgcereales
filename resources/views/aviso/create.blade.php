@extends('layout.master')
@section('content')
@parent

<head>
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-forms.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AvisoController@index') }}">Avisos</a> / Crear
            aviso</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <!-- aca iba la columna1  -->
                <form action="{{action('AvisoController@store')}}" method="POST">
                    {{ csrf_field() }}
                    <p class="form-title"><strong>Intermitentes</strong></p>
                    <label for="titular">
                        <span>Titular:*</span>
                        <select name="titular" id="labeltitular" class="common-input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($titulares as $titular)
                            <option value="{{ $titular->cuit }}" {{old('titular') == $titular->cuit ? 'selected':''}}>
                                {{$titular->nombre}}</option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#labeltitular").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="intermediario" class="input-margin">
                        <span>Intermediario:</span>
                        <select name="intermediario" id="labelintermediario" class="common-input">
                            <option value="" selected></option>
                            @foreach ($intermediarios as $intermediario)
                            <option value="{{ $intermediario->cuit }}"
                                {{old('intermediario') == $intermediario->cuit ? 'selected':''}}>
                                {{$intermediario->nombre}}</option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#labelintermediario").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                            allowClear: true
                        });
                        </script>
                    </label>
                    <label for="remitente" class="input-margin">
                        <span>Remitente Comercial:*</span>
                        <select name="remitente" id="labelremitente" class="common-input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($remitentes as $remitente)
                            <option value="{{ $remitente->cuit }}"
                                {{old('remitente') == $remitente->cuit ? 'selected':''}}>{{$remitente->nombre}}</option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#labelremitente").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="corredor">
                        <span>Corredor:*</span>
                        <select name="corredor" id="labelcorredor" class="common-input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($corredores as $corredor)
                            <option value="{{ $corredor->cuit }}"
                                {{old('corredor') == $corredor->cuit ? 'selected':''}}>{{$corredor->nombre}}</option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#labelcorredor").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true
                        });
                        </script>
                    </label>
                    <label for="destinatario" class="input-margin">
                        <span>Destinatario:*</span>
                        <select name="destinatario" id="labeldestinatario" class="common-input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($destinatarios as $destinatario)
                            <option value="{{ $destinatario->cuit }}"
                                {{old('destinatario') == $destinatario->cuit ? 'selected':''}}>{{$destinatario->nombre}}
                            </option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#labeldestinatario").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="lugarDescarga" class="input-margin">
                        <span>Destino:*</span>
                        <input type="text" value="{{old('lugarDescarga')}}" name="lugarDescarga" id="lugarDescarga"
                            class="common-input" required>
                    </label>
                    <label for="entregador">
                        <span>Entregador:</span>
                        <input type="text" value="{{old('entregador')}}" name="entregador" id="entregador"
                            class="common-input">
                    </label>
                    <hr>
            </div>
            <div>
                <!-- aca iba la columna1  -->
                <p class="form-title"><strong>Granos/Especie</strong></p>
                <label for="producto">
                    <span>Producto:*</span>
                    <select name="producto" class="common-input" id="labelproducto" required>
                        <option value="" selected disabled hidden></option>
                        @foreach ($productos as $producto)
                        <option value="{{ $producto->idProducto }}"
                            {{old('producto') == $producto->idProducto ? 'selected':''}}> {{$producto->nombre}}</option>
                        @endforeach
                    </select>
                    <script>
                    $.fn.select2.defaults.set('language', 'es');
                    $("#labelproducto").select2({
                        placeholder: 'Seleccione',
                        dropdownAutoWidth: true,
                    });
                    </script>
                </label>
                <label for="tipo" class="input-margin-granos">
                    <span>Tipo de Producto:</span>
                    <input type="text" value="{{old('tipo')}}" name="tipo" id="tipo" class="common-input">
                </label>
                <label for="cosecha" class="input-margin-granos">
                    <span>Cosecha:* </span>
                    20 <input type="number" value="{{old('cosecha1')}}" name="cosecha1" id="cosecha1" class="year-input"
                        min="10" max="99" required>
                    /20 <input type="number" value="{{old('cosecha2')}}" name="cosecha2" id="cosecha2"
                        class="year-input" min="10" max="99" required>
                </label>
                <hr>
                <p class="form-title"><strong>Procedencia de la mercaderia</strong></p>
                <label for="provincia">
                    <span>Provincia:*</span>
                    <select name="provincia" id="provincia" class="common-input" required>
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
                        width: 'resolve'
                    });
                    </script>
                </label>
                <label for="localidad" class="input-margin-procedencia">
                    <span>Localidad:*</span>
                    <select name="localidad" id="localidad" class="common-input" required>
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
                <hr>
                <label for="obs">
                    <p class="form-title"><strong>Observaciones</strong></p>
                    <textarea name="obs" id="obs" class="observation-box" style="height:80px;"
                        placeholder="Ingrese una observación" cols="150"></textarea>
                </label>
                <hr>
                <button type="submit" class="save-button" style="position:relative; top:50%; left:30%;"><i
                        class="fa fa-check"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
