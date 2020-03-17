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
						 <label for="nombre">Nombre</label>
						 <input type="text" name="nombre" id="nombre" class="form-control" value="{{$cargador->nombre}}">
					</div>

					<div class="form-group">
						<label for="cuit">CUIT {{$cargador->cuit}}</label> <!-- NO PUEDE SER EDITABLE A MENOS QUE SEA UPDATE CASCADE -->
						<!-- <input type="text" name="cuit" id="cuit" class="form-control" value="{{$cargador->cuit}}"> -->
					</div>

                    <!-- CONDICION IVA -->
					@foreach ($iva as $condicion)
						@if($condicion->idCondIva == $cargador->condIva)
							<!-- PARA CAMBIAR HACER LISTA -->
							<div class="form-group">
								<label for="condicion">Condicion de IVA</label>
								<input type="text" name="condicion" id="condicion" class="form-control" value="{{$condicion->descripcion}}">
							</div>
						@endif
					@endforeach

					<div class="form-group">
						<label for="dgr">DGR</label>
						<input type="text" name="dgr" id="dgr" class="form-control" value="{{$cargador->dgr}}">
					</div>

                    Modificar Domicilio: <br>
					<div class="form-group">
						<label for="cp">Codigo Postal</label>
						<input type="text" name="cp" id="cp" class="form-control" value="{{$cargador->cp}}">
					</div>

                    <div class="form-group">
						<label for="direccion">Dirección</label>
						<input type="text" name="domicilio" id="domicilio" class="form-control" value="{{$cargador->domicilio}}">
					</div>

                    <div class="form-group">
						<label for="localidad">Localidad</label>
						<input type="text" name="localidad" id="localidad" class="form-control" value="{{$cargador->localidad}}">
					</div>

                    <div class="form-group">
						<label for="provincia">Provincia</label>
						<input type="text" name="provincia" id="provincia" class="form-control" value="{{$cargador->provincia}}">
					</div>

                    <div class="form-group">
						<label for="pais">País</label>
						<input type="text" name="pais" id="pais" class="form-control" value="{{$cargador->pais}}">
					</div>

                    <!-- MODIFICAR CONTACTO  / AGREGAR / ELIMINAR -->

					<!--	DEBERIA SER UNA LISTA DONDE SE MUESTREN TODOS 
							Y AHI TENER LA OPCION DE AGREGAR O ELIMINAR -->

					<div class="form-group text-center">
                        <button type="submit">Guardar</button>
					</div>
				</form>
                <a href="{{ action('CargadorController@show', $cargador->cuit) }}"><button>Salir y no guardar</button></a>
			 </div>
		</div>
    </div>
    </div>
@endsection
