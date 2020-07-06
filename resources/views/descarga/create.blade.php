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
                <h2>Añadir datos de la descarga</h2>
                <div class="box">
			         <form action="{{action('DescargaController@store')}}" method="POST">
                     {{ csrf_field() }}
                     <label for="destino">
                        <span>Destinatario: *</span>
                        <select name="destino"  class="input" required>
                        <option value="" selected disabled hidden></option>
                           @foreach ($destinos as $destino)
                              <option value="{{ $destino->cuit }}"> {{$destino->nombre}}</option>
                           @endforeach
                        </select>
                     </label>
                     <label for="fecha">
                        <span>Fecha de la Descarga: *</span>
                        <input type="date" name="fecha" id="fecha" class="input" style="margin: 10px 20px;" required>
                     </label>
                     <label for="localidad">
                        <span>Localidad de descarga: *</span>
                        <input type="text" name="localidad" id="localidad" class="input" style="margin: 10px 20px;" required>
                     </label>
                     <label for="provincia">
                        <span>Provincia de descarga: *</span>
                        <input type="text" name="provincia" id="provincia" class="input" style="margin: 10px 20px;" required>
                     </label>
                     <label for="bruto">
                        <span>Kilos Brutos: *</span>
                        <input type="number" name="bruto" id="bruto" class="input" style="margin: 10px 20px;" required>
                     </label>
                     <label for="tara">
                        <span>Tara Kg: *</span>
                        <input type="number" name="tara" id="tara" class="input" style="margin: 10px 20px;" required>
                     </label>
                     <!-- KILOS NETOS SE CALCULA A PARTIR DE LOS BRUTOS - TARA -->
                     <label for="humedad">
                        <span>Humedad (%): *</span>
                        <input type="number" name="humedad" id="humedad" class="input" style="margin: 10px 20px;" required>
                     </label>
                     <!-- A PARTIR DE LA HUMEDAD SE CALCULA LA MERMA CON LA TABLA -->
                     <label for="ph">
                        <span>Ph: </span>
                        <input type="number" name="ph" id="ph" class="input" style="margin: 10px 20px;">
                     </label>
		               <label for="proteina">
                        <span>Proteina: </span>
                        <input type="number" name="proteina" id="proteina" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="calidad">
                        <span>Calidad: </span>
                        <input type="text" name="calidad" id="calidad" class="input" style="margin: 10px 20px;">
                     </label>
                     <input id="carga" name="carga" type="hidden" value="{{$carga->idCarga}}">
                     <button type="submit" class="save-button" style="position:relative; top:65%; left:30%;"><i class="fa fa-check"></i></button>
                     <a href="{{ action('AvisoController@index') }}"><button type="button" class="back-button" title="Salir" style="position: relative; top: 50%; right: 30%;"><i class="fa fa-arrow-left"></i></button></a>
                  </form>
               </div>
            </div>
         </div>
   </body>
@endsection
