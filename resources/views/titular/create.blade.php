@extends('layout.master')
@section('content')
	@parent
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
      		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body style="background:url(/image/cargador-camion.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Añadir titular</b></label>
    </div>
			<div class="container">
				<div class="card">
               <div class="box">
			         <form action="{{action('TitularController@store')}}" method="POST">
                     {{ csrf_field() }}
                     <label for="nombre">
                        <span>Nombre y apellido: *</span>
                        <input type="text" value="{{old('nombre')}}" name="nombre" id="nombre" class="input" style="margin: 10px 20px;" required>
                     </label>
                     <label for="cuit">
                        <span>CUIT: *</span>
                        <input type="text" value="{{old('cuit')}}" name="cuit" id="cuit" class="input" style="margin: 10px 20px;" min="0" max="999999999999999" required>
                     </label>
                     <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" value="{{old('dgr')}}" name="dgr" id="dgr" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="iva">
                        <span>IVA: *</span>
                        <select name="iva"  class="input" required>
                        <option value="" selected disabled hidden></option>
                           @foreach ($iva as $condicion)
                           <option value="{{ $condicion->idCondIva }}" {{old('iva') == $condicion->idCondIva ? 'selected':''}}>{{ $condicion->descripcion }}</option>
                           @endforeach
                        </select>
                     </label>
		               <label for="cp">
                        <span>Codigo postal: </span>
                        <input type="text" value="{{old('cp')}}" name="cp" id="cp" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="pais">
                        <span>Pais: </span>
                        <input type="text" value="{{old('pais')}}" name="pais" id="pais" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="provincia">
                        <span>Provincia: </span>
                        <input type="text" value="{{old('provincia')}}" name="provincia" id="provincia" class="input" style="margin: 10px 20px;">
                     </label>
                     <label for="localidad">
                        <span>Localidad: </span>
                        <input type="text" value="{{old('localidad')}}" name="localidad" id="localidad" class="input" style="margin: 10px 20px;">
                     </label>
		               <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" value="{{old('domicilio')}}" name="domicilio" id="domicilio" class="input" style="margin: 10px 20px;">
                     </label>
                     <button type="submit" class="save-button" style="position:relative; top:65%; left:30%;"><i class="fa fa-check"></i></button>
                     <a href="{{ action('TitularController@index') }}"><button type="button" class="back-button" title="Volver" style="position: relative; top: 50%; right: 30%;"><i class="fa fa-arrow-left"></i></button></a>
                  </form>
               </div>
            </div>
         </div>
         @include('sweet::alert')
   </body>
@endsection
