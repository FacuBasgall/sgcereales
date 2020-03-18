@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
	</head>
	<body style="background-image: url(/image/campo-trigo.jpg)">
		<div class="row" style="margin-top:40px">
			<div class="container">
				<div class="card" style="min-height:350px;">
               <h2>Agregar producto</h2>
               <div class="box" style=" left:25px; top:50%">
			         <form action="{{action('ProductoController@store')}}" method="POST">
                     {{ csrf_field() }}
                     <label for="nombre">
                        <span>Nombre: </span>
                        <input type="text" name="nombre" id="nombre" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="merma">
                        <span>Merma: </span>
                        <input type="text" name="merma" id="merma" class="input" style="margin: 10px 20px;">
                     </label>
                     <p>En caso de que no poseer merma, ingresar 0</p>
                     <button type="submit" class="save-button" style="position:absolute; top:95%; left:70%;"><i class="fa fa-check"></i></button>
                     <a href="{{ action('ProductoController@index') }}"><button type="button" class="delete-button" title="Cancelar" style="position: absolute; top: 95%; left: 25%;"><i class="fa fa-close"></i></button></a>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </body>
@endsection
