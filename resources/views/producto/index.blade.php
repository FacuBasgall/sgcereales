@extends('layout.master')
@section('content')
	@parent
    <head>
         <link rel="stylesheet" type="text/css" href="{{ asset('css/showProduct.css') }}" >
         <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>
    <body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Productos</b></label>
    </div>
    <form class="{{action('TitularController@index')}}" method="GET">
        {{ csrf_field() }}
        <input type="search" placeholder="Buscar..." name="search" id="search">
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
    <div class="container">
		@foreach( $productos as $key)

            <div class="card">
                <div class="box">
                <div class="img">
                    <img src="{{ URL::to('/image/producto-cereal.jpg') }}">
                </div>
                            <h2>{{$key->nombre}}</h2>
                            <p>Merma por manipuleo: {{$key->mermaManipuleo}}</p>
                            <hr></hr>
                            <a href="{{ action('ProductoController@show', $key->idProducto)}}"><button class="show-button" style="position: relative; top: 15%;" title="Ver más"><i class="fa fa-eye"></i> Ver</button></a>
                            <br><br>
                        </a>
                </div>
		    </div>

        @endforeach
        </div>
        @include('sweet::alert')

    </body>

@endsection



