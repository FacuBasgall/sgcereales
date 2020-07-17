@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
      		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body style="background:url(/image/silo.jpg) no-repeat center center fixed">
			<div class="container">
			    <div class="card">
                <h2>Crear nuevo aviso</h2>
                <div class="box">
			         <form action="{{action('AvisoController@store')}}" method="POST">
                     {{ csrf_field() }}
                     <p>Intermitentes</p>
                     <label for="titular">
                        <span>Titular: *</span>
                        <select name="titular"  class="input" required>
                        <option value="" selected disabled hidden></option>
                           @foreach ($titulares as $titular)
                              <option value="{{ $titular->cuit }}">{{$titular->nombre}}</option>
                           @endforeach
                        </select>
                     </label>
                     <label for="intermediario">
                        <span>Intermediario: </span>
                        <select name="intermediario"  class="input" >
                        <option value="" selected disabled hidden></option>
                           @foreach ($intermediarios as $intermediario)
                              <option value="{{ $intermediario->cuit }}">{{$intermediario->nombre}}</option>
                           @endforeach
                        </select>
                     </label>
                     <label for="remitente">
                        <span>Remitente Comercial: *</span>
                        <select name="remitente"  class="input" required>
                        <option value="" selected disabled hidden></option>
                           @foreach ($remitentes as $remitente)
                              <option value="{{ $remitente->cuit }}">{{$remitente->nombre}}</option>
                           @endforeach
                        </select>
                     </label>
                     <label for="corredor">
                        <span>Corredor: *</span>
                        <select name="corredor"  class="input" required>
                        <option value="" selected disabled hidden></option>
                           @foreach ($corredores as $corredor)
                              <option value="{{ $corredor->cuit }}">{{$corredor->nombre}}</option>
                           @endforeach
                        </select>
                     </label>
                     <label for="destinatario">
                        <span>Destinatario: *</span>
                        <select name="destinatario"  class="input" required>
                        <option value="" selected disabled hidden></option>
                           @foreach ($destinatarios as $destinatario)
                              <option value="{{ $destinatario->cuit }}">{{$destinatario->nombre}}</option>
                           @endforeach
                        </select>
                     </label>
                     <label for="destino">
                        <span>Lugar de descarga: *</span>
                        <input type="text" name="lugarDescarga" id="lugarDescarga" class="input" style="margin: 10px 20px;" required>
                     </label>
                    <!-- EL ENTREGADOR ES EL USUARIO QUE ESTA AUTENTICADO EN EL MOMENTO -->
                     <hr>
                     <p>Granos/Especie</p>
                     <label for="producto">
                        <span>Producto: *</span>
                        <select name="producto"  class="input" required>
                        <option value="" selected disabled hidden></option>
                           @foreach ($productos as $producto)
                              <option value="{{ $producto->idProducto }}"> {{$producto->nombre}}</option>
                           @endforeach
                        </select>
                     </label>
                     <label for="tipo">
                        <span>Tipo de Producto: </span>
                        <input type="text" name="tipo" id="tipo" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="cosecha">
                        <span>Año de Cosecha: *</span>
                        20
                        <input type="number" name="cosecha1" id="cosecha1" class="input" style="margin: 10px 20px;" min="10" max="99" required>
                        /20
                        <input type="number" name="cosecha2" id="cosecha2" class="input" style="margin: 10px 20px;" min="10" max="99" required>
                     </label>
                     <hr>
                     <p>Procedencia de la mercaderia</p>
                     <label for="provincia">
                        <span>Provincia de procedencia: *</span>
                        <input type="text" name="provincia" id="provincia" class="input" style="margin: 10px 20px;" required>
                     </label>
                     <label for="localidad">
                        <span>Localidad de procedencia: *</span>
                        <input type="text" name="localidad" id="localidad" class="input" style="margin: 10px 20px;" required>
                     </label>
                     <hr>
                     <button type="submit" class="save-button" style="position:relative; top:65%; left:30%;"><i class="fa fa-check"></i></button>
                     <a href="{{ action('AvisoController@index') }}"><button type="button" class="back-button" title="Volver" style="position: relative; top: 50%; right: 30%;"><i class="fa fa-arrow-left"></i></button></a>
                  </form>
               </div>
            </div>
         </div>
   </body>
@endsection
