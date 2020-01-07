@extends('layout.master')
@section('content')
	
    		<h2>{{$corredor->nombre}}</h2>
			<h4>CUIT: {{$corredor->cuit}}<br>
			
           <!--  <h4><strong>Infomación de contacto:</strong></h4><br>

            
            $arrayJoin = DB::table('corredor_contacto')
                ->join('tipo_contacto', 'corredor_contacto.tipo', '=', 'tipo_contacto.idTipoContacto')
                ->where('corredor_contacto.cuit', {{$corredor->cuit}})
                ->get();

            -->

			<a href="{{ action('CorredorController@edit', $corredor->cuit)}}"><button>Editar</button></a>
			<a href="{{ action('CorredorController@index') }}"><button>Volver</button></a>
@endsection
