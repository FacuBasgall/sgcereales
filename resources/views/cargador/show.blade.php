@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
      	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
    <body style="background:url(/image/cargador-camion.jpg) no-repeat center center fixed">
		<div class="container">
			<div class="card">
                <div class="box">
                    <div class="header">
    		        <h1>{{$cargador->nombre}}</h1>
                    <h2>CUIT: {{$cargador->cuit}}</h2>
                    <hr></hr>
                    @foreach ($iva as $condicion)
                        @if($condicion->idCondIva == $cargador->condIva)
                        <p><strong>Condicion de IVA: </strong>{{$condicion->descripcion}}</p>
                        @endif
                    @endforeach
                    @if (isset($cargador->dgr))
                        <p><strong>DGR: </strong>{{$cargador->dgr}}</p>
                    @else
                        <p><strong>DGR: </strong>No ingresado </p>
                    @endif
                    <hr>
                    <h4><strong>Domicilio del destinatario:</strong></h4>
                    @if (isset($cargador->cp))
                        <p><strong>CP: </strong>{{$cargador->cp}}</p>
                    @else
                        <p><strong>CP: </strong>Codigo Postal no definido</p>
                    @endif

                    @if (isset($cargador->domicilio))
                        <p><strong>Dirección: </strong>{{$cargador->domicilio}}</p>
                    @else
                        <p><strong>Dirección: </strong>Dirección no definida</p>
                    @endif

                    @if (isset($cargador->localidad))
                        <p><strong>Cuidad: </strong>{{$cargador->localidad}}</p>
                    @else
                        <p><strong>Cuidad: </strong>Cuidad no definida</p>
                    @endif

                    @if (isset($cargador->provincia))
                        <p><strong>Provincia: </strong>{{$cargador->provincia}}</p>
                    @else
                        <p><strong>Provincia: </strong>Provincia no definida</p>
                    @endif

                    @if (isset($cargador->pais))
                        <p><strong>País: </strong>{{$cargador->pais}}</p>
                    @else
                        <p><strong>País: </strong>País no definido</p>
                    @endif
            <hr>
            <h4><strong>Infomación de contacto:</strong></h4>
            @foreach ($tipoContacto as $tipo)
               @foreach ($contacto as $numero)
                   @if ($tipo->idTipoContacto == $numero->tipo)
                        <p><strong>{{$tipo->descripcion}}: </strong>{{$numero->contacto}}</p>
                   @endif
               @endforeach
            @endforeach
            <hr>
            <a href="{{ action('CargadorController@index') }}"><button class="back-button" title="Volver" style="position: relative; top: 10%; right: 20%;"><i class="fa fa-arrow-left"></i></button></a>
            <a href="{{ action('CargadorController@destroy', $cargador->cuit) }}"><button class="delete-button" title="Eliminar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-close"></i></button></a>
            <a href="{{ action('CargadorController@edit', $cargador->cuit)}}"><button class="edit-button" title="Editar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-pencil"></i></button></a>        
            </div>
            </div>
        </div>
    </body>

			
@endsection
