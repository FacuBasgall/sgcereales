@extends('layout.master')
@section('content')
	@parent
	<head>
         <link rel="stylesheet" type="text/css" href="{{ asset('css/showProduct.css') }}" >
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
	<body>
    <div class="card-header">
    <label class="title col-md-8 col-form-label"><b>Titulares carta porte</b></b></label>
    <a href="{{ action('TitularController@create') }}"><button class="plus-button" title="Añadir titular carta porte"><i class="fa fa-plus"></i> Añadir titular</button></a>
    </div>
    <div class="container">
		@foreach( $arrayTitular as $key)
		<div class="card">
                <div class="box">
					<div class="img">
						<img src="{{ URL::to('/image/cargador-icon.jpg') }}">
					</div>
					<h2>{{$key->nombre}}</h2>
					<p>CUIT: {{$key->cuit}}</p>

					<hr></hr>
					<a href="{{ action('TitularController@show', $key->cuit) }}"><button class="show-button" style="position: relative; top: 15%;" title="Ver más"><i class="fa fa-eye"></i></button></a>
					<br><br>
					</a>
                </div>
		    </div>

		@endforeach
        </div>
	@include('sweet::alert')
	</body>
@endsection

