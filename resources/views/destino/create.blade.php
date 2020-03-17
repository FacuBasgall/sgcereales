@extends('layout.master')
@section('content')
	@parent
   @parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
      		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body style="background:url(/image/silo.jpg)">
		<div class="row" style="margin-top:-20px">
			<div class="container">
				<div class="card" style="min-height:700px; ">
               <h2>Añadir destinatario</h2>
               <div class="box">
			         <form action="{{action('ProductoController@store')}}" method="POST">
                     {{ csrf_field() }}
                     <label for="cuit">CUIT: </label>
                     <input type="text" name="cuit" id="cuit" class="input" style="margin: 10px 20px;">
                     	<br>
                     <label for="nombre">Nombre y apellido: </label>
                     <input type="text" name="nombre" id="nombre" class="input" style="margin: 10px 20px;">
		     	            <br>
                     <label for="dgr">DGR: </label>
                     <input type="text" name="dgr" id="dgr" class="input" style="margin: 10px 20px;">
			               <br>
		               <label for="cp">Codigo postal: </label>
                     <input type="text" name="cp" id="cp" class="input" style="margin: 10px 20px;">
			               <br>
		                <label for="domicilio">Domicilio: </label>
                     <input type="text" name="domicilio" id="domicilio" class="input" style="margin: 10px 20px;">
			               <br>
		               <label for="localidad">Localidad: </label>
                     <input type="text" name="localidad" id="localidad" class="input" style="margin: 10px 20px;">
			               <br>
		               <label for="provincia">Provincia: </label>
                     <input type="text" name="provincia" id="provincia" class="input" style="margin: 10px 20px;">
			               <br>
		               <label for="pais">Pais: </label>
                     <input type="text" name="pais" id="pais" class="input" style="margin: 10px 20px;">
			
                     <button type="submit" class="save-button" style="position:absolute; top:100%; left:60%;"><i class="fa fa-check"></i></button>
                     <a href="{{ action('DestinoController@index') }}"><button type="button" class="delete-button" title="Cancelar" style="position: absolute; top: 100%; left: 20%;"><i class="fa fa-close"></i></button></a>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </body>
@endsection
