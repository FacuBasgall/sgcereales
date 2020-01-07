@extends('layout.master')
@section('content')
	@parent
		<div class="row" style="margin-top:40px">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Añadir Producto
         </div>
         <div class="card-body" style="padding:30px">
			<form action="{{action('ProductoController@store')}}" method="POST">
				{{ csrf_field() }}
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                </div>

                <div class="form-group">
                    <label for="merma">Merma</label>
                    <input type="text" name="merma" id="merma" class="form-control">
                    <p>En caso de que no poseer merma, ingresar 0</p>
                </div>

                <div class="form-group text-center">
                  <button type="submit">Guardar</button>
                </div>
            </form>
            <a href="{{ action('ProductoController@index') }}"><button>Salir y no guardar</button></a>
         </div>
      </div>
   </div>
</div>
@endsection
