@extends('layout.master')
@section('content')
	@parent
	<div class="row" style="margin-top:40px">
    <div class="offset-md-3 col-md-6">
		<div class="card">
			 <div class="card-header text-center">
					Modificar {{$cargador->nombre}}
			 </div>
			 <div class="card-body" style="padding:30px">
					<form action="{{action('CargadorController@update', '$cargador->cuit')}}" method="POST">
						{{ method_field('PUT') }}
						{{ csrf_field() }}
					<div class="form-group">
						 <label for="title">Nombre</label>
						 <input type="text" name="nombre" id="nombre" class="form-control" value="{{$cargador->nombre}}">
					</div>

					<div class="form-group">
						<label for="year">CUIT</label>
						<input type="text" name="cuit" id="cuit" class="form-control" value="{{$cargador->cuit}}">
					</div>

                    <!-- CONDICION IVA -->

					<div class="form-group">
						<label for="director">DGR</label>
						<input type="text" name="dgr" id="dgr" class="form-control" value="{{$cargador->dgr}}">
					</div>

                    Modificar Domicilio: <br>
					<div class="form-group">
						<label for="poster">Codigo Postal</label>
						<input type="text" name="cp" id="cp" class="form-control" value="{{$cargador->cp}}">
					</div>

                    <div class="form-group">
						<label for="poster">Dirección</label>
						<input type="text" name="domicilio" id="domicilio" class="form-control" value="{{$cargador->domicilio}}">
					</div>

                    <div class="form-group">
						<label for="poster">Localidad</label>
						<input type="text" name="localidad" id="localidad" class="form-control" value="{{$cargador->localidad}}">
					</div>

                    <div class="form-group">
						<label for="poster">Provincia</label>
						<input type="text" name="provincia" id="provincia" class="form-control" value="{{$cargador->provincia}}">
					</div>

                    <div class="form-group">
						<label for="poster">País</label>
						<input type="text" name="pais" id="pais" class="form-control" value="{{$cargador->pais}}">
					</div>

                    <!-- MODIFICAR CONTACTO  / AGREGAR / ELIMINAR -->

					<div class="form-group text-center">
                        <button type="submit">Guardar</button>
					</div>
				</form>
                <a href="{{ action('CargadorController@show', '$cargador->cuit') }}"><button>Salir y no guardar</button></a>
				<a href="{{ action('CorredorController@destroy', '$corredor->cuit') }}"><button>Eliminar</button></a>
			 </div>
		</div>
    </div>
    </div>
@endsection
