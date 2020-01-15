@extends('layout.master')
@section('content')
	@parent
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <div class="container">
	<div class="row">
		<h2>Listado de Avisos</h2>
        <a href="{{ action('AvisoController@create') }}"><button>Nuevo</button></a>
	</div>
	
	
	<div class="row">
	    
	    <div class='col-sm-8 col-md-8'>
	        
    	    
    	    <table class='table'>
    	        <thead>
    	            <tr>
                        <th>Numero de Aviso</th>
                        <th>Numero de Carta Porte</th>
                        <th>Producto</th>
                        <th>Acopiador</th>
                        <th>Destino</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                @foreach( $arrayAviso as $key)
                <tr>
                    <td>{{$key->idAviso}}</td>
                    <td>NRO CARTA PORTE</td>
                    <td>PRODUCTO</td>
                    <td>CARGADOR</td>
                    <td>DESTINO</td>
                    <td>FECHA</td>
                    <td>ESTADO</td>
                    @if ESTADO == 'T'
                    <td><a href="{{ action('AvisoController@show', $key->idAviso) }}"><button>Ver Detalles</button></a></td>
                    @else
                    <td><a href="{{ action('AvisoController@edit', $key->idAviso) }}"><button>Editar</button></a></td>
                    @endif
                </tr>
                @endforeach
                </tbody>
    	    </table>
    	    
	    </div>
	    
	    
	</div>
	
	
    </div>
@endsection