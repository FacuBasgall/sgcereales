@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
	</head>
	<body style="background-image:url(/image/corredor.jpg); no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Crear corredor</b></label>
    </div>
			<div class="container">
				<div class="card" style="min-height:350px;">
               <h2>Agregar Corredor</h2>
               <div class="box" style=" left:25px; top:50%">
			         <form action="{{action('CorredorController@store')}}" method="POST">
                     {{ csrf_field() }}
                     <label for="nombre">
                        <span>Nombre y Apellido: *</span>
                        <input type="text" name="nombre" id="nombre" class="input" style="margin: 10px 20px;" required>
                     </label>
                     <label for="cuit">
                        <span>CUIT: *</span>
                        <input type="number" name="cuit" id="cuit" class="input" style="margin: 10px 20px;" step="1" min="0" max="99999999999" required>
                     </label>
                     <button type="submit" class="save-button" style="position:absolute; top:90%; left:70%;"><i class="fa fa-check"></i></button>
                     <a href="{{ action('CorredorController@index') }}"><button type="button" class="back-button" title="Volver" style="position: absolute; top: 90%; left: 25%;"><i class="fa fa-arrow-left"></i></button></a>
                  </form>
               </div>
         </div>
      </div>
      @include('sweet::alert')
   </body>
@endsection
