@extends('layout.master')
@section('content')
	@parent
		<div class="row" style="margin-top:40px">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Añadir Corredor
         </div>
         <div class="card-body" style="padding:30px">
						<form action="{{action('CorredorController@store')}}" method="POST">
							{{ csrf_field() }}
            <div class="form-group">
               <label for="title">CUIT</label>
               <input type="text" name="cuit" id="cuit" class="form-control">
            </div>

            <div class="form-group">
							<label for="year">NOMBRE</label>
							<input type="text" name="nombre" id="nombre" class="form-control">
            </div>
            
             <!-- INFORMACION DE CONTACTO -->
            
            <div class="form-group text-center">
                <button type="submit">Guardar</button>
            </div>
		</form>
        <a href="{{ action('CorredorController@index') }}"><button>Salir y no guardar</button></a>
        </div>
      </div>
   </div>
</div>
@endsection
