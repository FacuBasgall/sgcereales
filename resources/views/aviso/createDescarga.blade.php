@extends('layout.master')
@section('content')
	@parent
    <div class="row" style="margin-top:40px">
    <div class="offset-md-3 col-md-6">
		<div class="card">
			 <div class="card-header text-center">
					Nuevo Aviso <br> Ingrese los datos de la <strong>Descarga</strong>:
			 </div>
             <div class="card-body" style="padding:30px">
				<form action="{{action('AvisoController@store')}}" method="POST">
				    {{ csrf_field() }}
                
                   <!-- FALTA TODOS LOS DATOS -->


                    <div class="form-group text-center">
                        <button type="submit">Guardar y Salir</button>
                    </div>
                </form>
                <a href="{{ action('AvisoController@index') }}"><button>Salir y no guardar</button></a>
            </div>
        </div>
    </div>
    </div>
    @endsection