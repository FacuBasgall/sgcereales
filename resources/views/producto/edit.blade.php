@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body style="background-image: url(/image/campo-trigo.jpg)">
	<div class="row" style="margin-top:40px">
 	<div class="container">
		<div class="card">
		<h2>Editar producto: {{$producto->nombre}}</h2>
			<div class="box">
					<form action="{{action('ProductoController@update', $producto->idProducto)}}" method="POST">
						{{ method_field('PUT') }}
						{{ csrf_field() }}
						<label>Merma: </label>
						<input type="text" name="merma" id="merma" class="input" value="{{$producto->merma}}">
						<br>
						<button type="submit" class="save-button" title="Guardar" style=" position: absolute; top: 80%; left: 60%;"><i class="fa fa-check"></i></button>
						<a href="{{action('ProductoController@index')}}"><button type="button" class="delete-button" title="Cancelar" style="position: absolute; top: 80%; right: 60%;"><i class="fa fa-close"></i></button></a>
					</form>
				
			</div>
		</div>
	</div>
	</div>
	</body>
@endsection