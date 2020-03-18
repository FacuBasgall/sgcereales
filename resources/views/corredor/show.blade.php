@extends('layout.master')
@section('content')
	
    		<h2>{{$corredor->nombre}}</h2>
			<h4>CUIT: {{$corredor->cuit}}<br><br>
			
           <h4><strong>Infomación de contacto:</strong></h4><br>
            @foreach ($tipoContacto as $tipo)
               @foreach ($contacto as $numero)
                   @if ($tipo->idTipoContacto == $numero->tipo)
                        <p><strong>{{$tipo->descripcion}}: </strong>{{$numero->contacto}}</p>
                   @endif
               @endforeach
            @endforeach

			<a href="{{ action('CorredorController@edit', $corredor->cuit)}}"><button>Editar</button></a>
            <a href="{{ action('CorredorController@destroy', $corredor->cuit) }}"><button>Eliminar</button></a>
			<a href="{{ action('CorredorController@index') }}"><button>Volver</button></a>
@endsection
