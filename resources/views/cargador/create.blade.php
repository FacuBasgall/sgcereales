@extends('layout.master')
@section('content')
	@parent
		<div class="row" style="margin-top:40px">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Añadir cargadores
         </div>
         <div class="card-body" style="padding:30px">
						<form action="{{action('CargadorController@store')}}" method="POST">
							{{ csrf_field() }}
            <div class="form-group">
               <label for="title">CUIT</label>
               <input type="text" name="cuit" id="cuit" class="form-control">
            </div>

            <div class="form-group">
							<label for="year">NOMBRE</label>
							<input type="text" name="nombre" id="nombre" class="form-control">
            </div>
            
             <!-- CONDICION IVA -->
             
            <div class="form-group">
							<label for="director">DGR</label>
							<input type="text" name="dgr" id="dgr" class="form-control">
            </div>

            <div class="form-group">
							<label for="poster">CODIGO POSTAL</label>
							<input type="text" name="cp" id="cp" class="form-control">
            </div>
            
            <div class="form-group">
							<label for="poster">DOMICILIO</label>
							<input type="text" name="domicilio" id="domicilio" class="form-control">
            </div>

            <div class="form-group">
							<label for="poster">LOCALIDAD</label>
							<input type="text" name="localidad" id="localidad" class="form-control">
            </div>

            <div class="form-group">
							<label for="poster">PROVINCIA</label>
							<input type="text" name="provincia" id="provincia" class="form-control">
            </div>

            <div class="form-group">
							<label for="poster">PAIS</label>
							<input type="text" name="pais" id="pais" class="form-control">
            </div>
          <!-- INFORMACION DE CONTACTO -->
            
          <div class="form-group text-center">
            <button type="submit">Guardar</button>
          </div>
		</form>
        <a href="{{ action('CargadorController@index') }}"><button>Salir y no guardar</button></a>
         </div>
      </div>
   </div>
</div>
@endsection
