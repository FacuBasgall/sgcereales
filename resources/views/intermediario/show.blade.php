@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
      	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
    <body style="background:url(/image/corredor.jpg) no-repeat center center fixed">
		<div class="container">
			<div class="card"> 
                <div class="box">
                    <div class="header">
    		        <h1>{{$intermediario->nombre}}</h1>
                    <h2>CUIT: {{$intermediario->cuit}}</h2>
                    
            <h4><strong>Infomación de contacto:</strong></h4>
            @foreach ($tipoContacto as $tipo)
               @foreach ($contacto as $numero)
                   @if ($tipo->idTipoContacto == $numero->tipo)
                        <p><strong>{{$tipo->descripcion}}: </strong>{{$numero->contacto}}</p>
                   @endif
               @endforeach
            @endforeach
            <hr>
            <a href="{{ action('IntermediarioController@index') }}"><button class="back-button" title="Volver" style="position: relative; top: 10%; right: 20%;"><i class="fa fa-arrow-left"></i></button></a>
            <a onclick="warning( '{{$intermediario->cuit}}' , 'corredor');"><button class="delete-button" title="Eliminar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-trash"></i></button></a>
            <a href="{{ action('IntermediarioController@edit', $intermediario->cuit)}}"><button class="edit-button" title="Editar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-pencil"></i></button></a>        
            </div>
            </div>
        </div>
    </body>

			
@endsection
