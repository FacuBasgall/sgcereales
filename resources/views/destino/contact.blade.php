@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
	</head>
	<body style="background-image:url(/image/corredor.jpg); no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Editar contactos de destinatario {{$destinatario->nombre}}</b></label>
    </div>
			<div class="container">
				<div class="card" style="min-height:350px;">
               <h2>Informacion de Contacto</h2>
               <div class="box" style=" left:25px; top:50%">
                @if (!$destinoContacto->isEmpty())
                    @foreach ($tipoContacto as $tipo)
                        @foreach ($destinoContacto as $contacto)
                            @if ($tipo->idTipoContacto == $contacto->tipo)
                                    <p><strong>{{$tipo->descripcion}}: </strong>{{$contacto->contacto}}</p>
                                    <a href="{{ action('DestinoController@delete_contact', $contacto->id)}}"><button  title="Eliminar" style="position: relative; top: 10%; left: 20%;">Eliminar</button></a>
                            @endif
                        @endforeach
                    @endforeach
                @else
                    <p>No se encontró información</p>
                @endif

               <form action="{{action('DestinoController@add_contact', $destinatario->cuit)}}" method="GET">
                     {{ csrf_field() }}
                    <h6><strong>Agregar infomación de contacto:</strong></h6>
                    <label for="tipo">
                        <select name="tipo" class="input" required>
                        <option value="" selected disabled hidden></option>
                        @foreach ($tipoContacto as $tipo)
                            <option value="{{$tipo->idTipoContacto}}">{{$tipo->descripcion}}</option>
                        @endforeach
                    </label>
                    <label for="contacto">
                        <input type="text" name="contacto" id="contacto" class="input" style="margin: 10px 20px;" required>
                    </label>
                    <button type="submit" class="save-button" style="position:absolute; top:90%; left:70%;"><i class="fa fa-check"></i></button>
                </form>
                    <a href="{{ action('DestinoController@show', $destinatario->cuit)}}"><button  title="Salir" style="position: relative; top: 10%; left: 20%;">Salir</button></a>
               </div>
         </div>
      </div>
   </body>
@endsection
