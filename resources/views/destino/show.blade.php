@extends('layout.master')
@section('content')
	
    		<h2>{{$destino->nombre}}</h2>
			<h4>CUIT: {{$destino->cuit}}<br>

            @foreach ($iva as $condicion)
                @if($condicion->idCondIva == $destino->condIva)
                <p><h4>Condicion de IVA: {{$condicion->descripcion}}</h4></p>
                @endif
            @endforeach

            @if (isset($destino->dgr))
                <p><strong>DGR: </strong>{{$destino->dgr}}</p>
			@else
                <p><strong>DGR: </strong>Valor no definido o 0</p>
			@endif

            <br><br><h4><strong>Domicilio del destinatario:</strong></h4><br>
            @if (isset($destino->cp))
                <p><strong>CP: </strong>{{$destino->cp}}</p>
			@else
                <p><strong>CP: </strong>Codigo Postal no definido</p>
			@endif

            @if (isset($destino->domicilio))
                <p><strong>Dirección: </strong>{{$destino->domicilio}}</p>
			@else
                <p><strong>Dirección: </strong>Dirección no definida</p>
			@endif

            @if (isset($destino->localidad))
                <p><strong>Cuidad: </strong>{{$destino->localidad}}</p>
			@else
                <p><strong>Cuidad: </strong>Cuidad no definida</p>
			@endif

            @if (isset($destino->provincia))
                <p><strong>Provincia: </strong>{{$destino->provincia}}</p>
			@else
                <p><strong>Provincia: </strong>Provincia no definida</p>
			@endif

            @if (isset($destino->pais))
                <p><strong>País: </strong>{{$destino->pais}}</p>
			@else
                <p><strong>País: </strong>País no definido</p>
			@endif


            <h4><strong>Infomación de contacto:</strong></h4><br>
            @foreach ($tipoContacto as $tipo)
               @foreach ($contacto as $numero)
                   @if ($tipo->idTipoContacto == $numero->tipo)
                        <p><strong>{{$tipo->descripcion}}: </strong>{{$numero->contacto}}</p>
                   @endif
               @endforeach
            @endforeach

			<a href="{{ action('DestinoController@edit', $destino->cuit)}}"><button>Editar</button></a>
            <a href="{{ action('DestinoController@destroy', $destino->cuit) }}"><button>Eliminar</button></a>
			<a href="{{ action('DestinoController@index') }}"><button>Volver</button></a>
@endsection
