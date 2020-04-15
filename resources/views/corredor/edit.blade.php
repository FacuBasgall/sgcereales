@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
      		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body style="background:url(/image/corredor.jpg) no-repeat center center fixed">
			<div class="container">
				<div class="card" style="min-height:325px; padding:10px;">
               <h2>Editar: {{$corredor->nombre}}</h2>
               <div class="box" style="margin-top: 20px">
			         <form action="{{action('CorredorController@update', $corredor->cuit)}}" method="POST">
                    	{{ method_field('PUT') }}
					    {{ csrf_field() }}
                     <label for="nombre">
                        <span>Nombre y apellido: </span>
                        <input type="text" name="nombre" id="nombre" class="input" value="{{$corredor->nombre}}" style="margin: 10px 20px;"  required>
                     </label>
                     <label for="cuit">
                        <span>CUIT: </span>
                        <input type="text" name="cuit" id="cuit" class="input" value="{{$corredor->cuit}}" style="margin: 10px 20px;" readonly>
                     </label>	
                     <button type="submit" class="save-button" style="position:relative; top:65%; left:45%;"><i class="fa fa-check"></i></button>
                     <a href="{{ action('CorredorController@index') }}"><button type="button" class="back-button" title="Volver" style="position: relative; top: 50%; right: 35%;"><i class="fa fa-arrow-left"></i></button></a>
                  </form>
               </div>
            </div>
         </div>
   </body>
@endsection
