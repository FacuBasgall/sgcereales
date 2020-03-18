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
		<div class="card" style="min-height:250px; width:400px; ">
		<h2>Editar producto: {{$producto->nombre}}</h2>
			<div class="box" style="left:15px; top:50%;">
					<form action="{{action('ProductoController@update', $producto->idProducto)}}" method="POST">
						{{ method_field('PUT') }}
						{{ csrf_field() }}
						<label>
							<span>Merma: </span>
							<input type="text" name="merma" id="merma" class="input" value="{{$producto->merma}}">
						</label>
						<button type="submit" class="save-button" title="Guardar" style=" position: absolute; top: 85%; left: 70%;"><i class="fa fa-check"></i></button>
						<a href="{{action('ProductoController@index')}}"><button type="button" class="delete-button" title="Cancelar" style="position: absolute; top: 85%; right: 70%;"><i class="fa fa-close"></i></button></a>
					</form>
				
			</div>
		</div>
	</div>
	</div>
	</body>
@endsection