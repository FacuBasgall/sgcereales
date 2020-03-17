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
					<form action="{{action('CorredorController@update', $corredor->cuit)}}" method="POST">
						{{ method_field('PUT') }}
						{{ csrf_field() }}
					<div class="form-group">
						 <label for="nombre">Nombre</label>
						 <input type="text" name="nombre" id="nombre" class="form-control" value="{{$corredor->nombre}}">
					</div>

					<div class="form-group">
						<label for="cuit">CUIT {{$corredor->cuit}}</label> <!-- NO PUEDE SER EDITABLE A MENOS QUE SEA UPDATE CASCADE -->
						<!-- <input type="text" name="cuit" id="cuit" class="form-control" value="{{$corredor->cuit}}"> NO DEBERIA SER MODIFICABLE -->
					</div>


					<!-- MODIFICAR CONTACTO / AGREGAR / ELIMINAR -->
					
					<!--	DEBERIA SER UNA LISTA DONDE SE MUESTREN TODOS 
							Y AHI TENER LA OPCION DE AGREGAR O ELIMINAR -->


					<div class="form-group text-center">
                        <button type="submit">Guardar</button>
					</div>
				</form>
                <a href="{{ action('CorredorController@show', $corredor->cuit) }}"><button>Salir y no guardar</button></a>
			 </div>
		</div>
    </div>
    </div>
@endsection
