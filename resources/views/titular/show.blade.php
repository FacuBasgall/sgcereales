@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
      	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
    <body style="background:url(/image/cargador-camion.jpg) no-repeat center center fixed">
		<div class="container">
			<div class="card">
                <div class="box">
                    <div class="header">
    		        <h1>{{$titular->nombre}}</h1>
                    <h2>CUIT: {{$titular->cuit}}</h2>
                    <hr></hr>
                    @foreach ($iva as $condicion)
                        @if($condicion->idCondIva == $titular->condIva)
                        <p><strong>Condicion de IVA: </strong>{{$condicion->descripcion}}</p>
                        @endif
                    @endforeach
                    @if (isset($titular->dgr))
                        <p><strong>DGR: </strong>{{$titular->dgr}}</p>
                    @else
                        <p><strong>DGR: </strong>No ingresado </p>
                    @endif
                    <hr>
                    <h4><strong>Domicilio del destinatario:</strong></h4>
                    @if (isset($titular->cp))
                        <p><strong>CP: </strong>{{$titular->cp}}</p>
                    @else
                        <p><strong>CP: </strong>Codigo Postal no definido</p>
                    @endif

                    @if (isset($titular->domicilio))
                        <p><strong>Dirección: </strong>{{$titular->domicilio}}</p>
                    @else
                        <p><strong>Dirección: </strong>Dirección no definida</p>
                    @endif

                    @if (isset($titular->localidad))
                        <p><strong>Cuidad: </strong>{{$titular->localidad}}</p>
                    @else
                        <p><strong>Cuidad: </strong>Cuidad no definida</p>
                    @endif

                    @if (isset($titular->provincia))
                        <p><strong>Provincia: </strong>{{$titular->provincia}}</p>
                    @else
                        <p><strong>Provincia: </strong>Provincia no definida</p>
                    @endif

                    @if (isset($titular->pais))
                        <p><strong>País: </strong>{{$titular->pais}}</p>
                    @else
                        <p><strong>País: </strong>País no definido</p>
                    @endif
            <hr>
            <h4><strong>Infomación de contacto: </strong><a href="{{ action('TitularController@contact', $titular->cuit) }}">Editar</a></h4>
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
            <a href="{{ action('TitularController@index') }}"><button class="back-button" title="Volver" style="position: relative; top: 10%; right: 20%;"><i class="fa fa-arrow-left"></i></button></a>
            <a onclick="warning( '{{$titular->cuit}}' , 'titular');"><button class="delete-button" title="Eliminar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-trash"></i></button></a>
            <a href="{{ action('TitularController@edit', $titular->cuit)}}"><button class="edit-button" title="Editar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-pencil"></i></button></a>
            </div>
            </div>
        </div>
    </body>


@endsection
