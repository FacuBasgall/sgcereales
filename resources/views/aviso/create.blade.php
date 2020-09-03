@extends('layout.master')
@section('content')
@parent

<head>
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
</head>

<body style="background:url(/image/silo.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Avisos / Crear aviso</b></label>
    </div>
    <div>
        <div>
            <div>
                <!-- aca iba la columna1  -->
                <form action="{{action('AvisoController@store')}}" method="POST">
                    {{ csrf_field() }}
                    <p>Intermitentes</p>
                    <label for="titular">
                        <span>Titular:*</span>
                        <select name="titular" id="titular" class="input" style="width:100%" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($titulares as $titular)
                            <option value="{{ $titular->cuit }}" {{old('titular') == $titular->cuit ? 'selected':''}}>
                                {{$titular->nombre}}</option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#titular").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="intermediario">
                        <span>Intermediario:</span>
                        <select name="intermediario" id="intermediario" class="input" style="width:100%">
                            <option value="" selected></option>
                            @foreach ($intermediarios as $intermediario)
                            <option value="{{ $intermediario->cuit }}"
                                {{old('intermediario') == $intermediario->cuit ? 'selected':''}}>
                                {{$intermediario->nombre}}</option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#intermediario").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="remitente">
                        <span>Remitente Comercial:*</span>
                        <select name="remitente" id="remitente" class="input" style="width:100%" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($remitentes as $remitente)
                            <option value="{{ $remitente->cuit }}"
                                {{old('remitente') == $remitente->cuit ? 'selected':''}}>{{$remitente->nombre}}</option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#remitente").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="corredor">
                        <span>Corredor:*</span>
                        <select name="corredor" id="corredor" class="input" style="width:100%" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($corredores as $corredor)
                            <option value="{{ $corredor->cuit }}"
                                {{old('corredor') == $corredor->cuit ? 'selected':''}}>{{$corredor->nombre}}</option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#corredor").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true
                        });
                        </script>
                    </label>
                    <label for="destinatario">
                        <span>Destinatario:*</span>
                        <select name="destinatario" id="destinatario" class="input" style="width:100%" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($destinatarios as $destinatario)
                            <option value="{{ $destinatario->cuit }}"
                                {{old('destinatario') == $destinatario->cuit ? 'selected':''}}>{{$destinatario->nombre}}
                            </option>
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#destinatario").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="lugarDescarga">
                        <span>Destino:*</span>
                        <input type="text" value="{{old('lugarDescarga')}}" name="lugarDescarga" id="lugarDescarga"
                            class="input" required>
                    </label>
                    <label for="entregador">
                        <span>Entregador:</span>
                        <input type="text" value="{{old('entregador')}}" name="entregador" id="entregador"
                            class="input">
                    </label>
                    <hr>
            </div>
            <div>
                <!-- aca iba la columna1  -->
                <p>Granos/Especie</p>
                <label for="producto">
                    <span>Producto:*</span>
                    <select name="producto" class="input" id="producto" style="width:100%" required>
                        <option value="" selected disabled hidden></option>
                        @foreach ($productos as $producto)
                        <option value="{{ $producto->idProducto }}"
                            {{old('producto') == $producto->idProducto ? 'selected':''}}> {{$producto->nombre}}</option>
                        @endforeach
                    </select>
                    <script>
                    $.fn.select2.defaults.set('language', 'es');
                    $("#producto").select2({
                        placeholder: 'Seleccione',
                        dropdownAutoWidth: true,
                    });
                    </script>
                </label>
                <label for="tipo">
                    <span>Tipo de Producto:</span>
                    <input type="text" value="{{old('tipo')}}" name="tipo" id="tipo" class="input">
                </label>
                <label for="cosecha">
                    <span>Cosecha:* </span>
                    20 <input type="number" value="{{old('cosecha1')}}" name="cosecha1" id="cosecha1" class="input-year"
                        min="10" max="99" required>
                    /20 <input type="number" value="{{old('cosecha2')}}" name="cosecha2" id="cosecha2"
                        class="input-year" min="10" max="99" required>
                </label>
                <hr>
                <p>Procedencia de la mercaderia</p>
                <label for="provincia">
                    <span>Provincia:*</span>
                    <select name="provincia" id="provincia" class="input" style="width:100%" required>
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
                <label for="localidad">
                    <span>Localidad:*</span>
                    <select name="localidad" id="localidad" class="input" style="width:100%" required>
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
                    <p>Observaciones </p>
                    <textarea name="obs" id="obs" class="observation-box" rows="10"
                        placeholder="Ingrese una observación" cols="25"></textarea>
                </label>
                <hr>
                <button type="submit" class="save-button" style="position:relative; top:50%; left:30%;"><i
                        class="fa fa-check"></i> Guardar y continuar</button>
                <a href="{{ action('AvisoController@index') }}"><button type="button" class="back-button" title="Volver"
                        style="position: relative; top: 50%; right: 50%;"><i class="fa fa-arrow-left"></i>
                        Volver</button></a>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
