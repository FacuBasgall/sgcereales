@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
</head>

<body style="background:url(/image/silo.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AvisoController@index') }}">Avisos</a> / <a
                href="{{ action('AvisoController@show', $aviso->idAviso) }}">Detalle del aviso</a> / Editar aviso
            {{$aviso->nroAviso}}</label>
    </div>
    <div class="container">
        <div class="card" style="height:1500px;width:450px;">
            <div class="box">
                <form action="{{action('AvisoController@update', $aviso->idAviso)}}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <p>Intermitentes</p>
                    <label for="titular">
                        <span>Titular:*</span>
                        <select name="titular" class="input" id="titular" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($titulares as $titular)
                            @if($titular->cuit == $aviso->idTitularCartaPorte)
                            <option value="{{$titular->cuit}}" selected>{{ $titular->nombre }}</option>
                            @else
                            <option value="{{ $titular->cuit }}">{{$titular->nombre}}</option>
                            @endif
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
                        <select name="intermediario" id="intermediario" class="input">
                            <option value="" selected></option>
                            @foreach ($intermediarios as $intermediario)
                            @if($intermediario->cuit == $aviso->idIntermediario)
                            <option value="{{$intermediario->cuit}}" selected>{{ $intermediario->nombre }}</option>
                            @else
                            <option value="{{ $intermediario->cuit }}">{{$intermediario->nombre}}</option>
                            @endif
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
                        <select name="remitente" class="input" id="remitente" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($remitentes as $remitente)
                            @if($remitente->cuit == $aviso->idRemitenteComercial)
                            <option value="{{$remitente->cuit}}" selected>{{ $remitente->nombre }}</option>
                            @else
                            <option value="{{ $remitente->cuit }}">{{$remitente->nombre}}</option>
                            @endif
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
                        <select name="corredor" class="input" id="corredor" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($corredores as $corredor)
                            @if($corredor->cuit == $aviso->idCorredor)
                            <option value="{{$corredor->cuit}}" selected>{{ $corredor->nombre }}</option>
                            @else
                            <option value="{{ $corredor->cuit }}">{{$corredor->nombre}}</option>
                            @endif
                            @endforeach
                        </select>
                        <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#corredor").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="destinatario">
                        <span>Destinatario:*</span>
                        <select name="destinatario" class="input" id="destinatario" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($destinatarios as $destinatario)
                            @if($destinatario->cuit == $aviso->idDestinatario)
                            <option value="{{$destinatario->cuit}}" selected>{{ $destinatario->nombre }}</option>
                            @else
                            <option value="{{ $destinatario->cuit }}">{{$destinatario->nombre}}</option>
                            @endif
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
                        <input type="text" value="{{$aviso->lugarDescarga}}" name="lugarDescarga" id="lugarDescarga"
                            class="input" required>
                    </label>
                    <!-- EL ENTREGADOR ES EL USUARIO QUE ESTA AUTENTICADO EN EL MOMENTO -->
                    <hr>
                    <p>Granos/Especie</p>
                    <label for="producto">
                        <span>Producto:*</span>
                        <select name="producto" class="input" id="producto" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($productos as $producto)
                            @if($producto->idProducto == $aviso->idProducto)
                            <option value="{{ $producto->idProducto }}" selected>{{ $producto->nombre }}</option>
                            @else
                            <option value="{{ $producto->idProducto }}">{{$producto->nombre}}</option>
                            @endif
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
                        <input type="text" value="{{$aviso_producto->tipo}}" name="tipo" id="tipo" class="input">
                    </label>
                    <label for="cosecha">
                        @php $año1 = substr($aviso_producto->cosecha, 2, 2);
                        $año2 = substr($aviso_producto->cosecha, -2, 2);
                        @endphp
                        <span>Cosecha:*</span>
                        20 <input type="number" value="{{$año1}}" name="cosecha1" id="cosecha1" class="input-year"
                            min="10" max="99" required>
                        /20 <input type="number" value="{{$año2}}" name="cosecha2" id="cosecha2" class="input-year"
                            min="10" max="99" required>
                    </label>
                    <hr>
                    <p>Procedencia de la mercaderia</p>
                    <label for="provincia">
                        <span>Provincia:</span>
                        <select name="provincia" id="provincia" class="input" >
                            <option value="" selected disabled hidden></option>
                            @foreach ($provincias as $provincia)
                            @if($provincia->id == $aviso->provinciaProcedencia)
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
                        <span>Localidad:</span>
                        <select name="localidad" id="localidad" class="input" >
                            <option value="" selected disabled hidden></option>
                            @foreach ($localidades as $localidad)
                            @if($localidad->id == $aviso->localidadProcedencia)
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
                    <hr>
                    <label for="obs">
                        <p>Observaciónes</p>
                        <textarea name="obs" id="obs" value="{{$aviso->observacion}}" class="observation-box" rows="10"
                            cols="40"></textarea>
                    </label>
                    <hr style="width: 420px;">
                    <button type="submit" class="save-button"><i class="fa fa-check"></i> Guardar</button>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
