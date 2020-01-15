@extends('layout.master')
@section('content')
	@parent
	<div class="row" style="margin-top:40px">
    <div class="offset-md-3 col-md-6">
		<div class="card">
			 <div class="card-header text-center">
					Modificar Numero de Aviso: {{$aviso->idAviso}}
			 </div>
			 <div class="card-body" style="padding:30px">
					<form action="{{action('AvisoController@update', '$aviso->idAviso')}}" method="POST">
						{{ method_field('PUT') }}
						{{ csrf_field() }}

					<div class="form-group">
						<label for="year">idAviso</label>
						<input type="text" name="idAviso" id="idAviso" class="form-control" value="{{$aviso->idAviso}}">
					</div>

                   <!-- FALTA TODOS LOS DATOS -->

					<div class="form-group text-center">
                        <button type="submit">Guardar</button>
					</div>
				</form>
                <a href="{{ action('AvisoController@show', '$aviso->idAviso') }}"><button>Salir y no guardar</button></a>
			 </div>
		</div>
    </div>
    </div>
@endsection
