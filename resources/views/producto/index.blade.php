@extends('layout.master')
@section('content')
	@parent
		@foreach( $arrayProductos as $key)
		    <div>
                    <h2>{{$key->nombre}}</h2>
                    @if ($key->merma != 0)
                        <h4>{{$key->merma}}% de merma</h4>
                    @else
                        <h4>Este producto no posee merma</h4>
                    @endif
                    <a href="{{ action('ProductoController@edit', $key->idProducto)}}"><button>Editar</button></a>
                    <br><br>
                </a>
		    </div>
		@endforeach
		
@endsection