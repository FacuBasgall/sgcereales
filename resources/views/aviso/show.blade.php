@extends('layout.master')
@section('content')
    @parent
	Esto es una vista de prueba<br>
    <strong>ID Aviso: </strong>{{$aviso->idAviso}}<br>
    <strong>Producto: </strong>{{$producto->nombre}}<br>
    <strong>Corredor: </strong>{{$corredor->nombre}}<br>
    @if($aviso->estado == false)
        <strong>Estado: </strong>Pendiente<br>
        <a href="{{ action('AvisoController@edit', $aviso->idAviso) }}"><button class="plus-button" title="Editar">Editar</button></a>
    @else
        <strong>Estado: </strong>Terminado<br>
        Editar no disponible
    @endif
    <br><br>
    Información de la carga:<br>
    <strong>Titular: </strong>{{$titular->nombre}}<br>
    <strong>Lugar de procedencia: </strong>{{$titular->localidad}}, {{$titular->provincia}}<br>
    <strong>Fecha: </strong>{{$carga->fecha}}<br>
    <strong>KG: </strong>{{$carga->kilos}}<br>
    <br>
    Información de la descarga:<br>
    @foreach($descargas as $descarga)
        <strong>Fecha: </strong>{{$descarga->fecha}}<br>
        @foreach($destinos as $destino)
            @if($descarga->idDestinatario == $destino->cuit)
                <strong>Destinatario: </strong>{{$destino->nombre}}<br>
                <strong>Lugar de destino: </strong>{{$destino->localidad}}, {{$destino->provincia}}<br>
            @endif
        @endforeach
        <br>
    @endforeach
@endsection
