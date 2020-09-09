@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="background:url(/image/cargador-camion.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('CorredorController@index') }}">Corredores</a> /
            Detalle del corredor</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="header">
                    <h1>{{$corredor->nombre}}</h1>
                    <h2>CUIT: {{$corredor->cuit}}</h2>
                </div>
                <hr>
                </hr>
                @foreach ($iva as $condicion)
                @if($condicion->idCondIva == $corredor->condIva)
                <p><strong>Condición de IVA: </strong>{{$condicion->descripcion}}</p>
                @endif
                @endforeach
                @if (isset($corredor->dgr))
                <p><strong>DGR: </strong>{{$corredor->dgr}}</p>
                @else
                <p><strong>DGR: </strong>No ingresado </p>
                @endif
                <hr>
                <h2>Domicilio</h2>
                @if (isset($corredor->cp))
                <p><strong>CP: </strong>{{$corredor->cp}}</p>
                @else
                <p><strong>CP: </strong>Codigo Postal no definido</p>
                @endif

                @if (isset($corredor->domicilio))
                <p><strong>Dirección: </strong>{{$corredor->domicilio}}</p>
                @else
                <p><strong>Dirección: </strong>Dirección no definida</p>
                @endif

                @if (isset($corredor->localidad))
                <p><strong>Ciudad: </strong>{{$localidad->nombre}}</p>
                @else
                <p><strong>Ciudad: </strong>Ciudad no definida</p>
                @endif

                @if (isset($corredor->provincia))
                <p><strong>Provincia: </strong>{{$provincia->nombre}}</p>
                @else
                <p><strong>Provincia: </strong>Provincia no definida</p>
                @endif

                @if (isset($corredor->pais))
                <p><strong>País: </strong>{{$corredor->pais}}</p>
                @else
                <p><strong>País: </strong>País no definido</p>
                @endif
                <hr>
                <strong>
                    <h2>Contactos <a href="{{ action('CorredorController@contact', $corredor->cuit) }}"><button
                                class="small-edit-button" title="Gestionar contactos"><i
                                    class="fa fa-pencil"></i></button></a></h2>
                </strong>
                @if (!$contacto->isEmpty())
                @foreach ($tipoContacto as $tipo)
                @foreach ($contacto as $numero)
                @if ($tipo->idTipoContacto == $numero->tipo)
                <p><strong>{{$tipo->descripcion}}: </strong>{{$numero->contacto}}</p>
                @endif
                @endforeach
                @endforeach
                @else
                <p>No se encontró información</p>
                @endif
                <hr>
                <a onclick="warning( '{{$corredor->cuit}}' , 'corredor');"><button class="delete-button"
                        title="Eliminar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-trash"></i>
                        Eliminar</button></a>
                <a href="{{ action('CorredorController@edit', $corredor->cuit)}}"><button class="edit-button"
                        title="Editar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-pencil"></i>
                        Editar</button></a>
            </div>
        </div>
        @include('sweet::alert')
</body>
@endsection
