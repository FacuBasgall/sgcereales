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
               <h2>Añadir destinatario</h2>
               <div class="box">
			         <form action="{{action('DestinoController@store')}}" method="POST">
                     {{ csrf_field() }}
                     <label for="nombre">
                        <span>Nombre y apellido: </span>
                        <input type="text" name="nombre" id="nombre" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="cuit">
                        <span>CUIT: </span>
                        <input type="text" name="cuit" id="cuit" class="input" style="margin: 10px 20px;">
                     </label>	
                     <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" name="dgr" id="dgr" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="iva">
                        <span>IVA: </span>
                        <select name="iva"  class="input">
                        <option value=""></option>
                           @foreach ($iva as $condicion)
                           <option value="{{ $condicion->idCondIva }}">{{ $condicion->descripcion }}</option>
                           @endforeach
                        </select>
                     </label>
		               <label for="cp">
                        <span>Codigo postal: </span>
                        <input type="text" name="cp" id="cp" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="pais">
                        <span>Pais: </span>
                        <input type="text" name="pais" id="pais" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="provincia">
                        <span>Provincia: </span>
                        <input type="text" name="provincia" id="provincia" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="localidad">
                        <span>Localidad: </span>
                        <input type="text" name="localidad" id="localidad" class="input" style="margin: 10px 20px;">
                     </label>
		               <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" name="domicilio" id="domicilio" class="input" style="margin: 10px 20px;">
                     </label>
                     <button type="submit" class="save-button" style="position:relative; top:65%; left:30%;"><i class="fa fa-check"></i></button>
                     <a href="{{ action('DestinoController@index') }}"><button type="button" class="delete-button" title="Cancelar" style="position: relative; top: 50%; right: 30%;"><i class="fa fa-close"></i></button></a>
                  </form>
               </div>
            </div>
         </div>
   </body>
@endsection
