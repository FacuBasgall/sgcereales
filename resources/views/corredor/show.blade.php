@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
      	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
    <body style="background:url(/image/corredor.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Detalle del corredor</b></label>
    </div>
		<div class="container">
			<div class="card">
                <div class="box">
                    <div class="header">
    		        <h1>{{$corredor->nombre}}</h1>
                    <h2>CUIT: {{$corredor->cuit}}</h2>
            <hr>
            <h4><strong>Infomación de contacto: </strong><a href="{{ action('CorredorController@contact', $corredor->cuit) }}">Editar</a></h4>
            @if (!$contacto->isEmpty())
                @foreach ($tipoContacto as $tipo)
                    @foreach ($contacto as $numero)
                        @if ($tipo->idTipoContacto == $numero->tipo)
                                <p><strong>{{$tipo->descripcion}}: </strong>{{$numero->contacto}}</p>
                        @endif
                    @endforeach
                @endforeach
            @else
            <p>No se encontró información</p>
            @endif
            <hr>
            <a href="{{ action('CorredorController@index') }}"><button class="back-button" title="Volver" style="position: relative; top: 10%; right: 20%;"><i class="fa fa-arrow-left"></i></button></a>
            <a onclick="warning( '{{$corredor->cuit}}' , 'corredor');"><button class="delete-button" title="Eliminar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-trash"></i></button></a>
            <a href="{{ action('CorredorController@edit', $corredor->cuit)}}"><button class="edit-button" title="Editar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-pencil"></i></button></a>
            </div>
            </div>
        </div>
        @include('sweet::alert')
    </body>
@endsection
