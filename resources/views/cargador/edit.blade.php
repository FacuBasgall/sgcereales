@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
      		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body style="background:url(/image/cargador-camion.jpg) no-repeat center center fixed">
			<div class="container">
				<div class="card">
               <h2>Editar: {{$cargador->nombre}}</h2>
			   <br>
               <div class="box">
			         <form action="{{action('CargadorController@update', $cargador->cuit)}}" method="POST">
                    {{ method_field('PUT') }}
					{{ csrf_field() }}
                     <label for="nombre">
                        <span>Nombre y apellido: </span>
                        <input type="text" name="nombre" id="nombre" class="input" value="{{$cargador->nombre}}" style="margin: 10px 20px;"  required>
                     </label>
                     <label for="cuit">
                        <span>CUIT: </span>
                        <input type="number" name="cuit" id="cuit" class="input" value="{{$cargador->cuit}}" style="margin: 10px 20px;" readonly>
                     </label>	
                     <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" name="dgr" id="dgr" class="input" value="{{$cargador->dgr}}" style="margin: 10px 20px;">
                     </label>
                     <label for="iva">
                        <span>IVA: </span>
                        <select name="iva"  class="input">
						@foreach ($iva as $condicion)
							@if($condicion->idCondIva == $cargador->condIva)
								<option value="{{$condicion->idCondIva}}" selected>{{ $condicion->descripcion }}</option>
							@endif
							<option value="{{ $condicion->idCondIva }}">{{ $condicion->descripcion }}</option>
                        @endforeach
                        </select>
                     </label>
		               <label for="cp">
                        <span>Codigo postal: </span>
                        <input type="text" name="cp" id="cp" class="input"  value="{{$cargador->cp}}" style="margin: 10px 20px;">
                     </label>
                     <label for="pais">
                        <span>Pais: </span>
                        <input type="text" name="pais" id="pais" class="input" value="{{$cargador->pais}}" style="margin: 10px 20px;">
                     </label>
                     <label for="provincia">
                        <span>Provincia: </span>
                        <input type="text" name="provincia" id="provincia" class="input" value="{{$cargador->provincia}}" style="margin: 10px 20px;">
                     </label>
                     <label for="localidad">
                        <span>Localidad: </span>
                        <input type="text" name="localidad" id="localidad" class="input" value="{{$cargador->localidad}}" style="margin: 10px 20px;">
                     </label>
		               <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" name="domicilio" id="domicilio" class="input" value="{{$cargador->domicilio}}" style="margin: 10px 20px;">
                     </label>
                     <button type="submit" class="save-button" style="position:relative; top:65%; left:30%;"><i class="fa fa-check"></i></button>
                     <a href="{{ action('CargadorController@index') }}"><button type="button" class="back-button" title="Volver" style="position: relative; top: 50%; right: 30%;"><i class="fa fa-arrow-left"></i></button></a>
                  </form>
               </div>
            </div>
         </div>
   </body>
@endsection
