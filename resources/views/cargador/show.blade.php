@extends('layout.master')
@section('content')
	
    		<h2>{{$cargador->nombre}}</h2>
			<h4>CUIT: {{$cargador->cuit}}<br>
			Condicion de IVA: </h4><br>
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


           <!--  <h4><strong>Infomación de contacto:</strong></h4><br>

            
            $arrayJoin = DB::table('cargador_contacto')
                ->join('tipo_contacto', 'cargador_contacto.tipo', '=', 'tipo_contacto.idTipoContacto')
                ->where('cargador_contacto.cuit', {{$cargador->cuit}})
                ->get();

            -->

			<a href="{{ action('CargadorController@edit', $cargador->cuit)}}"><button>Editar</button></a>
            <a href="{{ action('CargadorController@destroy', '$cargador->cuit') }}"><button>Eliminar</button></a>
			<a href="{{ action('CargadorController@index') }}"><button>Volver</button></a>
@endsection
