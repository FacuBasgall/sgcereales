@extends('layout.master')
@section('content')
	@parent
    
    @foreach ($avisos as $aviso)
        
        <strong>ID de Aviso:</strong> {{$aviso->idAviso}}
        @foreach ($productos as $producto)
            @if ($producto->idProducto == $aviso->idProducto)
                <strong>Producto:</strong> {{$producto->nombre}}
            @endif
        @endforeach
        @foreach ($corredores as $corredor)
            @if ($corredor->cuit == $aviso->idCorredor)
                <strong>Corredor:</strong> {{$corredor->nombre}}
            @endif
        @endforeach
        @foreach ($entregadores as $entregador)
            @if ($entregador->idUser == $aviso->idEntregador)
                <strong>Entregador:</strong> {{$entregador->username}}
            @endif
        @endforeach
        @foreach ($avisos_entregadores as $aviso_entregador)
            @if ($aviso_entregador->idAviso == $aviso->idAviso)
                <strong>Fecha:</strong> {{$aviso_entregador->fecha}}
            @endif
        @endforeach
        @if ($aviso->estado == true)
            <strong>Estado:</strong> Terminada
        @else
            <strong>Estado:</strong> Pendiente
        @endif
        @foreach ($cargas as $carga)
            @if ($carga->idAviso == $aviso->idAviso)
                @foreach ($cargadores as $cargador)
                    @if ($carga->idCargador == $cargador->cuit)
                        <strong>Cargador:</strong> {{$cargador->nombre}}
                    @endif
                @endforeach
            @endif
        @endforeach

    @endforeach

@endsection