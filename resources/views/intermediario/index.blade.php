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
    <div class="container">
		@foreach( $arrayIntermediario as $key)
		<div class="card">
                <div class="box">
					<div class="img">
						<img src="{{ URL::to('/image/icon-corredor.jpg') }}">
					</div>
					<h2>{{$key->nombre}}</h2>
					<p>CUIT: {{$key->cuit}}</p>

					<hr></hr>
					<a href="{{ action('IntermediarioController@show', $key->cuit) }}"><button class="show-button" style="position: relative; top: 15%;" title="Ver más"><i class="fa fa-eye"></i></button></a>
					<br><br>
					</a>
                </div>
		    </div>

		@endforeach
        </div>
        <a href="{{ action('IntermediarioController@create') }}"><button class="plus-button" title="Agregar corredor"><i class="fa fa-plus"></i></button></a>
		@include('sweet::alert')
	</body>	
@endsection

