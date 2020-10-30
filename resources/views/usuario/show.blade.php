@extends('config.index')
@section('option')
<div class="content-title m-x-auto">
    <i class="fa fa-address-card"></i> Datos personales
</div>
<div class="container">
    <div class="card">
        <div class="box">
            <hr>
            <div class="form-title">Datos del usuario <a
                    href="{{ action('UsuarioController@edit')}}"><button class="small-edit-button"
                        title="Editar"><i class="fa fa-pencil"></i></button></a></div>
            <label class="labels"><strong>Nombre y Apellido: </strong>{{auth()->user()->nombre}}</label>
            <label class="labels"><strong>CUIT: </strong>{{auth()->user()->cuit}}</label>
            <br>
            <label class="labels"><strong>Descripción: </strong>{{auth()->user()->descripcion}}</label>
            <br>
            <div class="form-title">Domicilios <a
                    href="{{action('UsuarioController@domicile')}}"><button class="small-edit-button"
                        title="Gestionar direcciones"><i class="fa fa-pencil"></i></button></a></div>
            @foreach($entregadorDomicilio as $domicilio)
                <label class="labels"><strong>País: </strong>{{$domicilio->pais}}</label>

                <label class="labels"><strong>Provincia: </strong>
                @if (isset($domicilio->provincia))
                @foreach($provincias as $provincia)
                @if($domicilio->provincia == $provincia->id)
                    {{$provincia->nombre}}</label>
                @endif
                @endforeach
                @else
                    <label class="info-text">-</label></label>
                @endif

                <label class="labels"><strong>Ciudad: </strong>
                @if (isset($domicilio->localidad))
                @foreach($localidades as $localidad)
                @if($domicilio->localidad == $localidad->id)
                    {{$localidad->nombre}}</label>
                @endif
                @endforeach
                @else
                    <label class="info-text">-</label></label>
                @endif

                <label class="labels"><strong>CP: </strong>
                @if (isset($domicilio->cp))
                    {{$domicilio->cp}}</label>
                @else
                <label class="info-text">-</label></label>
                @endif

                <label class="labels"><strong>Dirección: </strong>{{$domicilio->domicilio}}</label>
            @endforeach
            <hr>
            <div class="form-title">Contactos <a
                    href="{{ action('UsuarioController@contact') }}"><button class="small-edit-button"
                        title="Gestionar contactos"><i class="fa fa-pencil"></i></button></a></div>
            @if (!$entregadorContacto->isEmpty())
            @foreach ($tipoContacto as $tipo)
            @foreach ($entregadorContacto as $numero)
            @if ($tipo->idTipoContacto == $numero->tipo)
            <label class="labels"><strong>{{$tipo->descripcion}}: </strong>{{$numero->contacto}}</label>
            @endif
            @endforeach
            @endforeach
            @else
            <label class="labels info-text"><i class="fa fa-exclamation-circle"></i> No se encontraron contactos</label>
            @endif
        </div>
    </div>
</div>
@endsection
