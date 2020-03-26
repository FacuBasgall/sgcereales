@extends('layout.master')
@section('content')
	@parent
    <head>
         <link rel="stylesheet" type="text/css" href="{{ asset('css/showProduct.css') }}" >
         <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}" >
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/sweetAlert.js') }}"></script>
    </head>
    <body>
    <div class="container">
		@foreach( $arrayProductos as $key)
        
            <div class="card">
                <div class="box">
                <div class="img">
                    <img src="{{ URL::to('/image/producto-cereal.jpg') }}">
                </div>
                            <h2>{{$key->nombre}}</h2>
                            @if ($key->merma != 0)
                                <p>Merma: {{$key->merma}}%</p>
                            @else
                                <p>Este producto no posee merma</p>
                            @endif
                            <hr></hr>
                            <a onclick="warning( '{{$key->idProducto}}' , 'producto');"><button type="button" class="button delete-button" title="Borrar" style="position: relative; bottom: 50%; right: 20%;"><i class="fa fa-close"></i></button></a>
                            <a href="{{ action('ProductoController@edit', $key->idProducto)}}"><button class="edit-button" title="Editar" style="position: relative; top: 20%; left: 20%;"><i class="fa fa-pencil"></i></button></a>
                            <br><br>
                        </a>
                </div>
		    </div>

        @endforeach
        </div>
        <a href="{{ action('ProductoController@create') }}"><button class="plus-button" title="Agregar producto"><i class="fa fa-plus"></i></button></a>
        @include('sweet::alert')
    </body>	
@endsection



