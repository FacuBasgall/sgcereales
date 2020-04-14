@extends('layout.master')
@section('content')
	@parent
    <head>
         <link rel="stylesheet" type="text/css" href="{{ asset('css/showProduct.css') }}" >
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>
    <body>
    <div class="container">
		@foreach( $productos as $key)
        
            <div class="card">
                <div class="box">
                <div class="img">
                    <img src="{{ URL::to('/image/producto-cereal.jpg') }}">
                </div>
                            <h2>{{$key->nombre}}</h2>
                            <hr></hr>
                            <a href="{{ action('ProductoController@show', $key->idProducto)}}"><button class="show-button" style="position: relative; top: 15%;" title="Ver más"><i class="fa fa-eye"></i></button></a>
                            <br><br>
                        </a>
                </div>
		    </div>

        @endforeach
        </div>
        @include('sweet::alert')

    </body>	

@endsection



