@extends('layout.master')
@section('content')
	
    		                   <!-- FALTA TODOS LOS DATOS -->


			<a href="{{ action('AvisoController@edit', $aviso->idAviso)}}"><button>Editar</button></a>
            <a href="{{ action('AvisoController@destroy', '$aviso->idAviso') }}"><button>Eliminar</button></a>
			<a href="{{ action('AvisoController@index') }}"><button>Volver</button></a>
@endsection
