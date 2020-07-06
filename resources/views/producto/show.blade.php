@extends('layout.master')
@section('content')
	@parent
		<head>
			<style>
				table {
					font-family: arial, sans-serif;
					border-collapse: collapse;
					width: 100%;
				}

				td, th {
				border: 1px solid #dddddd;
				text-align: left;
				padding: 8px;
				}

				tr:nth-child(even) {
				background-color: #dddddd;
				}
			</style>
		</head>
		<body>
			<h1>{{$producto->nombre}}</h1>
            <h4>Merma por manipuleo: {{$producto->mermaManipuleo}}</h4><br>
			<h4>Tabla de merma por secado: </h4>
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
		</body>
@endsection
