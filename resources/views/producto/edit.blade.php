@extends('layout.master')
@section('content')
	@parent
	<div class="row" style="margin-top:40px">
 <div class="offset-md-3 col-md-6">
		<div class="card">
			 <div class="card-header text-center">
					Modificar Merma
			 </div>
			 <div class="card-body" style="padding:30px">
					<form action="{{action('ProductoController@update', $producto->idProducto)}}" method="POST">
						{{ method_field('PUT') }}
						{{ csrf_field() }}
					<div class="form-group">
						 <label for="title">Merma</label>
						 <input type="text" name="merma" id="merma" class="form-control" value="{{$producto->merma}}">
					</div>
					<div class="form-group text-center">
						<button type="submit">Guardar</button>
					</div>
				</form>
				<a href="{{action('ProductoController@index')}}"><button>Volver</button></a>
			 </div>
		</div>
 </div>
</div>
@endsection