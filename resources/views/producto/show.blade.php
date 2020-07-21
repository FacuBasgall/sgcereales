@extends('layout.master')
@section('content')
	@parent
		<head>
            <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
		</head>
		<body style="background:url(/image/silo.jpg) no-repeat center center fixed">
        <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Detalle de producto</b></label>
        </div>
		<div class="container">
			<div class="card">
                <div class="box">
                    <div class="header">
			            <h1>{{$producto->nombre}}</h1>
                        <hr></hr>
                    </div>
            <p><strong>Merma por manipuleo: </strong>{{$producto->mermaManipuleo}}</p>
			<p><strong>Tabla de merma por secado: </strong></p>
			<table style="width:15%">
				<tr>
					<th>Humedad</th>
					<th>Merma</th>
				</tr>
				@foreach ($mermas as $merma)
					<tr>
						<td>{{$merma->humedad}}</td>
						<td>{{$merma->merma}}</td>
					</tr>
				@endforeach
			</table>
            </div>
            </div>
    </body>
@endsection
