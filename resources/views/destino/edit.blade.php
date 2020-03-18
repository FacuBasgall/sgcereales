@extends('layout.master')
@section('content')
	@parent
	<div class="row" style="margin-top:40px">
    <div class="offset-md-3 col-md-6">
		<div class="card">
			 <div class="card-header text-center">
					Modificar {{$destino->nombre}}
			 </div>
			 <div class="card-body" style="padding:30px">
					<form action="{{action('DestinoController@update', '$destino->cuit')}}" method="POST">
						{{ method_field('PUT') }}
						{{ csrf_field() }}
					<div class="form-group">
						 <label for="nombre">Nombre</label>
						 <input type="text" name="nombre" id="nombre" class="form-control" value="{{$destino->nombre}}">
					</div>

					<div class="form-group">
						<label for="cuit">CUIT {{$destino->cuit}}</label> <!-- NO PUEDE SER EDITABLE A MENOS QUE SEA UPDATE CASCADE -->
						<!-- <input type="text" name="cuit" id="cuit" class="form-control" value="{{$destino->cuit}}"> -->
					</div>

                    <!-- CONDICION IVA -->
					@foreach ($iva as $condicion)
						@if($condicion->idCondIva == $destino->condIva)
							<!-- PARA CAMBIAR HACER LISTA -->
							<div class="form-group">
								<label for="condicion">Condicion de IVA</label>
								<input type="text" name="condicion" id="condicion" class="form-control" value="{{$condicion->descripcion}}">
							</div>
						@endif
					@endforeach

					<div class="form-group">
						<label for="dgr">DGR</label>
						<input type="text" name="dgr" id="dgr" class="form-control" value="{{$destino->dgr}}">
					</div>

                    Modificar Domicilio: <br>
					<div class="form-group">
						<label for="cp">Codigo Postal</label>
						<input type="text" name="cp" id="cp" class="form-control" value="{{$destino->cp}}">
					</div>

                    <div class="form-group">
						<label for="direccion">Dirección</label>
						<input type="text" name="domicilio" id="domicilio" class="form-control" value="{{$destino->domicilio}}">
					</div>

                    <div class="form-group">
						<label for="localidad">Localidad</label>
						<input type="text" name="localidad" id="localidad" class="form-control" value="{{$destino->localidad}}">
					</div>

                    <div class="form-group">
						<label for="provincia">Provincia</label>
						<input type="text" name="provincia" id="provincia" class="form-control" value="{{$destino->provincia}}">
					</div>

                    <div class="form-group">
						<label for="pais">País</label>
						<input type="text" name="pais" id="pais" class="form-control" value="{{$destino->pais}}">
					</div>

                    <!-- MODIFICAR CONTACTO / AGREGAR / ELIMINAR -->
					
					<!--	DEBERIA SER UNA LISTA DONDE SE MUESTREN TODOS 
							Y AHI TENER LA OPCION DE AGREGAR O ELIMINAR -->

					<div class="form-group text-center">
                        <button type="submit">Guardar</button>	
					</div>
				</form>
                <a href="{{ action('DestinoController@show', $destino->cuit) }}"><button>Salir y no guardar</button></a>
			 </div>
		</div>
    </div>
    </div>
@endsection
