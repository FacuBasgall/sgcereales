@extends('layout.master')
@section('content')
	@parent
		<div class="row">
		@foreach( $arrayCargador as $key)
		<div class="col-xs-6 col-sm-4 col-md-3 text-center">
		<a href="{{ action('CargadorController@show', $key->cuit )}}">
		<!-- <img src="" style="height:200px"/> PONER IMAGEN GENERICA -->
		<h4 style="min-height:45px;margin:5px 0 10px 0">
		{{$key->nombre}}
        CUIT: {{$key->cuit}}
		</h4>
		</a>
		</div>
		@endforeach
		</div>
@endsection