@extends('layout.master')
@section('content')
@parent

<head>
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-forms.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AvisoController@index') }}">Avisos</a> <i
                class="fa fa-chevron-right"></i> <a href="{{ action('AvisoController@show', $aviso->idAviso) }}">Detalle
                del aviso</a> <i class="fa fa-chevron-right"></i> Editar aviso
            {{$aviso->nroAviso}}</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <form action="{{action('AvisoController@update', $aviso->idAviso)}}" method="POST" autocomplete="off">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <p class="form-title"><strong>Intermitentes</strong></p>
                    <label for="titular" class="margin-right">
                        <span>Titular*:</span>
                        <select name="titular" class="common-input" id="labeltitular" required>
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
                        $("#labeltitular").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="intermediario" class="margin-right">
                        <span>Intermediario:</span>
                        <select name="intermediario" id="labelintermediario" class="common-input">
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
                        $("#labelintermediario").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="remitente" class="margin-right">
                        <span>Remitente comercial*:</span>
                        <select name="remitente" class="common-input" id="labelremitente" required>
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
                        $("#labelremitente").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="corredor" class="margin-right">
                        <span>Corredor*:</span>
                        <select name="corredor" class="common-input" id="labelcorredor" required>
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
                        $("#labelcorredor").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="destinatario" class="margin-right">
                        <span>Destinatario*:</span>
                        <select name="destinatario" class="common-input" id="labeldestinatario" required>
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
                        $("#labeldestinatario").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                        });
                        </script>
                    </label>
                    <label for="lugarDescarga">
                        <span>Destino*:</span>
                        <input type="text" value="{{$aviso->lugarDescarga}}" name="lugarDescarga" class="common-input"
                            list="lugarDescarga" maxlength="100" required>
                        <datalist id="lugarDescarga">
                            @foreach ((array)$lugarDescarga as $destino)
                            <option value="{{$destino->lugarDescarga}}"></option>
                            @endforeach
                        </datalist>
                    </label>
                    <!-- EL ENTREGADOR ES EL USUARIO QUE ESTA AUTENTICADO EN EL MOMENTO -->
                    <label for="entregador">
                        <span>Entregador:</span>
                        <input type="text" value="{{$aviso->entregador}}" name="entregador" id="entregador"
                            class="common-input" maxlength="50">
                    </label>
                    <hr>
            </div>
            <div>
                <p class="form-title"><strong>Granos/Especie</strong></p>
                <label for="producto" class="margin-right">
                    <span>Producto*:</span>
                    <select name="producto" class="common-input" id="labelproducto" required>
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
                    $("#labelproducto").select2({
                        placeholder: 'Seleccione',
                        dropdownAutoWidth: true,
                    });
                    </script>
                </label>
                <label for="tipo">
                    <span>Tipo de producto:</span>
                    <input type="text" value="{{$aviso_producto->tipo}}" name="tipo" class="common-input"
                        maxlength="150" list="tipo">
                    <datalist id="tipo">
                        @foreach ((array)$tipoProducto as $tipo)
                        <option value="{{$tipo->tipo}}"></option>
                        @endforeach
                    </datalist>
                </label>
                <label for="cosecha">
                    @php $año1 = substr($aviso_producto->cosecha, 2, 2);
                    $año2 = substr($aviso_producto->cosecha, -2, 2);
                    @endphp
                    <span>Cosecha*:</span>
                    20 <input type="number" value="{{$año1}}" name="cosecha1" id="cosecha1" class="year-input" min="10"
                        max="99" required>
                    /20 <input type="number" value="{{$año2}}" name="cosecha2" id="cosecha2" class="year-input" min="10"
                        max="99" required>
                </label>
                <hr>
                <p class="form-title"><strong>Procedencia de la mercaderia</strong></p>
                <label for="provincia" class="margin-right">
                    <span>Provincia*:</span>
                    <select name="provincia" id="provincia" class="common-input">
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
                <label for="localidad" class="margin-right">
                    <span>Localidad*:</span>
                    <select name="localidad" id="localidad" class="common-input">
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
                    <p class="form-title"><strong>Observaciones</strong></p>
                    <textarea name="obs" id="obs" value="{{$aviso->observacion}}" class="observation-box"
                        style="height:80px;" placeholder="Ingrese una observación" cols="150"></textarea>
                </label>
                <hr>
                <div class="center-of-page"><button type="submit" class="save-button"><i class="fa fa-check"></i>
                        Guardar</button></div>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
