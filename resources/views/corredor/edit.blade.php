@extends('layout.master')
@section('content')
	@parent
	<div class="row" style="margin-top:40px">
    <div class="offset-md-3 col-md-6">
		<div class="card">
			 <div class="card-header text-center">
					Modificar {{$corredor->nombre}}
			 </div>
			 <div class="card-body" style="padding:30px">
					<form action="{{action('corredorController@update', '$corredor->cuit')}}" method="POST">
						{{ method_field('PUT') }}
						{{ csrf_field() }}
					<div class="form-group">
						 <label for="title">Nombre</label>
						 <input type="text" name="nombre" id="nombre" class="form-control" value="{{$corredor->nombre}}">
					</div>

					<div class="form-group">
						<label for="year">CUIT</label>
						<input type="text" name="cuit" id="cuit" class="form-control" value="{{$corredor->cuit}}">
					</div>


                    <!-- MODIFICAR CONTACTO  / AGREGAR / ELIMINAR -->

					<div class="form-group text-center">
                        <button type="submit">Guardar</button>
					</div>
				</form>
                <a href="{{ action('CorredorController@show', '$corredor->cuit') }}"><button>Salir y no guardar</button></a>
			 </div>
		</div>
    </div>
    </div>
@endsection
