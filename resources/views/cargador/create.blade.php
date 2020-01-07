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
            
            <div class="form-group">
							<label for="director">DGR</label>
							<input type="text" name="dgr" id="dgr" class="form-control">
            </div>

            <div class="form-group">
							<label for="poster">CODIGO POSTAL</label>
							<input type="text" name="cp" id="cp" class="form-control">
            </div>
            
            <div class="form-group text-center">
              <a href="#"><button>Añadir Cargador</button></a>
            </div>
					</form>
         </div>
      </div>
   </div>
</div>
@endsection
