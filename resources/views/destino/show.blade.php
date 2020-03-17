@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
      	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
    <body style="background:url(/image/cereals-show.jpg); background-size: cover;">
		<div class="row" style="margin-top:-20px">
			<div class="container">
				<div class="card">
                <div class="box">
    		        <h1>{{$destino->nombre}}</h1>
                    <h2>CUIT: {{$destino->cuit}}</h2><br>
                    Condicion de IVA: </h2><br>
                    @if (isset($destino->dgr))
                        <p><strong>DGR: </strong>{{$destino->dgr}}</p>
                    @else
                        <p><strong>DGR: </strong>Valor no definido o 0</p>
                    @endif

                    <br><br><h4><strong>Domicilio del destinatario:</strong></h4><br>
                    @if (isset($destino->cp))
                        <p><strong>CP: </strong>{{$destino->cp}}</p>
                    @else
                        <p><strong>CP: </strong>Codigo Postal no definido</p>
                    @endif

                    @if (isset($destino->domicilio))
                        <p><strong>Dirección: </strong>{{$destino->domicilio}}</p>
                    @else
                        <p><strong>Dirección: </strong>Dirección no definida</p>
                    @endif

                    @if (isset($destino->localidad))
                        <p><strong>Cuidad: </strong>{{$destino->localidad}}</p>
                    @else
                        <p><strong>Cuidad: </strong>Cuidad no definida</p>
                    @endif

                    @if (isset($destino->provincia))
                        <p><strong>Provincia: </strong>{{$destino->provincia}}</p>
                    @else
                        <p><strong>Provincia: </strong>Provincia no definida</p>
                    @endif

                    @if (isset($destino->pais))
                        <p><strong>País: </strong>{{$destino->pais}}</p>
                    @else
                        <p><strong>País: </strong>País no definido</p>
                    @endif
                    <a href="{{ action('DestinoController@edit', $destino->cuit)}}"><button>Editar</button></a>
                    <a href="{{ action('DestinoController@destroy', '$destino->cuit') }}"><button>Eliminar</button></a>
                    <a href="{{ action('DestinoController@index') }}"><button>Volver</button></a>
                </div>
                </div>
            </div>
        </div>
    </body>

           <!--  <h4><strong>Infomación de contacto:</strong></h4><br>

            
            $arrayJoin = DB::table('destino_contacto')
                ->join('tipo_contacto', 'destino_contacto.tipo', '=', 'tipo_contacto.idTipoContacto')
                ->where('destino_contacto.cuit', {{$destino->cuit}})
                ->get();

            -->

			
@endsection
