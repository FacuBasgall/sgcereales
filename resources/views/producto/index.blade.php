@extends('layout.master')
@section('content')
	@parent
		@foreach( $arrayProductos as $key)
		    <div class="col-xs-6 col-sm-4 col-md-3 text-center">
                    <h2 style="min-height:45px;margin:5px 0 10px 0">{{$key->nombre}}</h2>
                    @if ($key->merma == 0)
                        <h4 style="min-height:45px;margin:5px 0 10px 0">{{$key->merma}}</h4>
                        <a href="{{ action('ProductoController@edit', $arrayProductos->idProducto)}}"><button>Editar</button></a>
                    @endif
                </a>
		    </div>
		@endforeach
		
@endsection