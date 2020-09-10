@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('RemitenteController@index') }}">Remitentes comercial</a>
            <i class="fa fa-chevron-right"></i> Detalle del remitente</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="header-title">
                    <strong>
                        <div>{{$remitente->nombre}}</div>
                    </strong>
                </div>
                <hr>
                <div class="form-title">Datos del remitente<a
                        href="{{ action('RemitenteController@edit', $remitente->cuit)}}"><button class="small-edit-button"
                            title="Editar"><i class="fa fa-pencil"></i></button></a></div>
                <label class="labels"><strong>CUIT: </strong>{{$remitente->cuit}}</label>
                @foreach ($iva as $condicion)
                @if($condicion->idCondIva == $remitente->condIva)
                <label class="labels"><strong>Condición de IVA: </strong>{{$condicion->descripcion}}</label>
                @endif
                @endforeach
                @if (isset($remitente->dgr))
                <label class="labels"><strong>DGR: </strong>{{$remitente->dgr}}</label>
                @else
                <label class="labels"><strong>DGR: </strong>No ingresado </label>
                @endif
                <br>
                @if (isset($remitente->pais))
                <label class="labels"><strong>País: </strong>{{$remitente->pais}}</label>
                @else
                <label class="labels"><strong>País: </strong>País no definido</label>
                @endif

                @if (isset($remitente->provincia))
                <label class="labels"><strong>Provincia: </strong>{{$provincia->nombre}}</label>
                @else
                <label class="labels"><strong>Provincia: </strong>Provincia no definida</label>
                @endif

                @if (isset($remitente->localidad))
                <label class="labels"><strong>Ciudad: </strong>{{$localidad->nombre}}</label>
                @else
                <label class="labels"><strong>Ciudad: </strong>Ciudad no definida</label>
                @endif

                @if (isset($remitente->cp))
                <label class="labels"><strong>CP: </strong>{{$remitente->cp}}</label>
                @else
                <label class="labels"><strong>CP: </strong>Código Postal no definido</label>
                @endif

                @if (isset($remitente->domicilio))
                <label class="labels"><strong>Dirección: </strong>{{$remitente->domicilio}}</label>
                @else
                <label class="labels"><strong>Dirección: </strong>Dirección no definida</label>
                @endif
                <hr>
                <div class="form-title">Contactos <a
                        href="{{ action('RemitenteController@contact', $remitente->cuit) }}"><button
                            class="small-edit-button" title="Gestionar contactos"><i
                                class="fa fa-pencil"></i></button></a></div>
                @if (!$contacto->isEmpty())
                @foreach ($tipoContacto as $tipo)
                @foreach ($contacto as $numero)
                @if ($tipo->idTipoContacto == $numero->tipo)
                <label class="labels"><strong>{{$tipo->descripcion}}: </strong>{{$numero->contacto}}</label>
                @endif
                @endforeach
                @endforeach
                @else
                <label class="labels">No se encontró información</label>
                @endif
                <hr>
                <div class="center-of-page"><a onclick="warning( '{{$remitente->cuit}}' , 'remitente');"><button
                            class="delete-button" title="Eliminar"><i class="fa fa-trash"></i>
                            Eliminar</button></a>
                </div>
            </div>
        </div>
        @include('sweet::alert')
</body>
@endsection
