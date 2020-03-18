@extends('layout.master')
@section('content')
	
    		<h2>{{$cargador->nombre}}</h2>
			<h4>CUIT: {{$cargador->cuit}}</h4><br>
            @foreach ($iva as $condicion)
                @if($condicion->idCondIva == $cargador->condIva)
                <p><h4>Condicion de IVA: {{$condicion->descripcion}}</h4></p>
                @endif
            @endforeach
            @if (isset($cargador->dgr))
                <p><strong>DGR: </strong>{{$cargador->dgr}}</p>
			@else
                <p><strong>DGR: </strong>Valor no definido o 0</p>
			@endif

            <br><br><h4><strong>Domicilio del Cargador:</strong></h4><br>
            @if (isset($cargador->cp))
                <p><strong>CP: </strong>{{$cargador->cp}}</p>
			@else
                <p><strong>CP: </strong>Codigo Postal no definido</p>
			@endif

            @if (isset($cargador->domicilio))
                <p><strong>Dirección: </strong>{{$cargador->domicilio}}</p>
			@else
                <p><strong>Dirección: </strong>Dirección no definida</p>
			@endif

            @if (isset($cargador->localidad))
                <p><strong>Cuidad: </strong>{{$cargador->localidad}}</p>
			@else
                <p><strong>Cuidad: </strong>Cuidad no definida</p>
			@endif

            @if (isset($cargador->provincia))
                <p><strong>Provincia: </strong>{{$cargador->provincia}}</p>
			@else
                <p><strong>Provincia: </strong>Provincia no definida</p>
			@endif

            @if (isset($cargador->pais))
                <p><strong>País: </strong>{{$cargador->pais}}</p>
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

			<a href="{{ action('CargadorController@edit', $cargador->cuit)}}"><button>Editar</button></a>
            <a href="{{ action('CargadorController@destroy', $cargador->cuit) }}"><button>Eliminar</button></a>
			<a href="{{ action('CargadorController@index') }}"><button>Volver</button></a>
@endsection
