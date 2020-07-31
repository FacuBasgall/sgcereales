@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="background:url(/image/silo.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Detalle de destinatario</b></label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="header">
                    <h1>{{$destino->nombre}}</h1>
                    <h2>CUIT: {{$destino->cuit}}</h2>
                    <hr>
                    </hr>
                    @foreach ($iva as $condicion)
                    @if($condicion->idCondIva == $destino->condIva)
                    <p><strong>Condicion de IVA: </strong>{{$condicion->descripcion}}</p>
                    @endif
                    @endforeach
                    @if (isset($destino->dgr))
                    <p><strong>DGR: </strong>{{$destino->dgr}}</p>
                    @else
                    <p><strong>DGR: </strong>No ingresado </p>
                    @endif
                    <hr>
                    <h4><strong>Domicilio del destinatario:</strong></h4>
                    @if (isset($destino->cp))
                    <p><strong>CP: </strong>{{$destino->cp}}</p>
                    @else
                    <p><strong>CP: </strong>Codigo Postal no definido</p>
                    @endif

                    @if (isset($destino->domicilio))
                    <p><strong>Dirección: </strong>{{$destino->domicilio}}</p>
                    @else
                    <p><strong>Dirección: </strong>Dirección no definida</p>
                    @endif

                    @if (isset($destino->localidad))
                    <p><strong>Cuidad: </strong>{{$destino->localidad}}</p>
                    @else
                    <p><strong>Cuidad: </strong>Cuidad no definida</p>
                    @endif

                    @if (isset($destino->provincia))
                    <p><strong>Provincia: </strong>{{$destino->provincia}}</p>
                    @else
                    <p><strong>Provincia: </strong>Provincia no definida</p>
                    @endif

                    @if (isset($destino->pais))
                    <p><strong>País: </strong>{{$destino->pais}}</p>
                    @else
                    <p><strong>País: </strong>País no definido</p>
                    @endif
                    <hr>
                    <strong>
                        <h2>Contactos <a href="{{ action('DestinoController@contact', $destino->cuit) }}"><button
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
                    <a href="{{ action('DestinoController@index') }}"><button class="back-button" title="Volver"
                            style="position: relative;"><i class="fa fa-arrow-left"></i> Volver</button></a>
                    <a onclick="warning( '{{$destino->cuit}}' , 'destino');"><button class="delete-button"
                            title="Eliminar" style="position: relative; top: 10%; left: 20%;"><i
                                class="fa fa-trash"></i> Eliminar</button></a>
                    <a href="{{ action('DestinoController@edit', $destino->cuit)}}"><button class="edit-button"
                            title="Editar" style="position: relative; top: 10%; left: 20%;"><i class="fa fa-pencil"></i>
                            Editar</button></a>
                </div>
            </div>
        </div>
        @include('sweet::alert')
</body>
@endsection
