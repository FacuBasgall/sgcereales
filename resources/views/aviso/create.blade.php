@extends('layout.master')
@section('content')
	@parent
    <div class="row" style="margin-top:40px">
    <div class="offset-md-3 col-md-6">
		<div class="card">
			 <div class="card-header text-center">
					Nuevo Aviso <br> Ingrese los datos de la <strong>Carga</strong>:
			 </div>
             <div class="card-body" style="padding:30px">
				<form action="#" method="POST">
				    {{ csrf_field() }}
                
                   <!-- FALTA TODOS LOS DATOS -->


                    <input type="submit" name="guardar" value="Guardar y Salir" onclick=this.form.action="{{action('AvisoController@storeCarga', false)}}">
                    <input type="submit" name="continuar" value="Continuar" onclick=this.form.action="{{action('AvisoController@storeCarga', true)}}">
                </form>
                <a href="{{ action('AvisoController@index') }}"><button>Salir y no guardar</button></a>
            </div>
        </div>
    </div>
    </div>
    @endsection