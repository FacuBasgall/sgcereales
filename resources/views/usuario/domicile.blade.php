@extends('layout.master')
@section('content')
@parent
<div class="content-title m-x-auto">
    <i class="fa fa-address-card"></i> <a href="{{ action('UsuarioController@show') }}">Datos personales</a> <i
        class="fa fa-chevron-right"></i> Gestión de domicilios
</div>
<div class="container">
    <div class="form-card">
        <span class="form-title"><strong>Añadir infomación del domicilio</strong></span><br>
        <form action="{{action('UsuarioController@add_domicile')}}" method="GET" autocomplete="off">
            {{ csrf_field() }}
            <label for="pais" class="margin-right">
                <span>País: </span>
                <select name="pais" id="pais" class="common-input" onChange="paisOnChange(this)" required>
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
                <input type="text" value="{{old('otroPais')}}" name="otroPais" id="otroPais" class="common-input"
                    maxlength="100">
            </label>
            <label for="domicilio">
                <span>Domicilio: </span>
                <input type="text" value="{{old('domicilio')}}" name="domicilio" id="domicilio"
                    class="common-input-address" maxlength="250" required>
            </label>
            <hr>
            <div class="center-of-page"> <button type="submit" class="save-button"><i class="fa fa-check"></i>
                    Añadir</button> </div>
        </form>
    </div>
    <div class="contacts-card">
        <div class="form-title"><strong>Gestión de domicilios</strong></div>
        <div class="flex-elements">
            @if ($entregadorDomicilio != NULL)
            @foreach($entregadorDomicilio as $domicilio)
            <div class="margin-right">
            {{$domicilio->domicilio}}, {{$domicilio->localidad}}({{$domicilio->cp}}), {{$domicilio->provincia}}, {{$domicilio->pais}}
            <a onclick="warningDomicile('{{$domicilio->idDomicilio}}', 'usuario');"><button class="small-delete-button"
                        title="Eliminar"><i class="fa fa-trash"></i></button></a>
            </div>
            @endforeach
            @else
            <p>No se encontró información</p>
            @endif
        </div>
    </div>

</div>

@endsection
