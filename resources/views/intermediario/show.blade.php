@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('IntermediarioController@index') }}">Intermediarios</a>
            <i class="fa fa-chevron-right"></i> Detalle del intermediario</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="header-title">
                    <strong>
                        <div>{{$intermediario->nombre}}</div>
                    </strong>
                </div>
                <hr>
                <div class="form-title">Datos del intermediario <a
                        href="{{ action('IntermediarioController@edit', $intermediario->cuit)}}"><button class="small-edit-button"
                            title="Editar"><i class="fa fa-pencil"></i></button></a></div>
                <label class="labels"><strong>CUIT: </strong>{{$intermediario->cuit}}</label>
                @foreach ($iva as $condicion)
                @if($condicion->idCondIva == $intermediario->condIva)
                <label class="labels"><strong>Condición de IVA: </strong>{{$condicion->descripcion}}</label>
                @endif
                @endforeach
                @if (isset($intermediario->dgr))
                <label class="labels"><strong>DGR: </strong>{{$intermediario->dgr}}</label>
                @else
                <label class="labels"><strong>DGR: </strong><label class="info-text">-</label> </label>
                @endif
                <br>
                @if (isset($intermediario->pais))
                <label class="labels"><strong>País: </strong>{{$intermediario->pais}}</label>
                @else
                <label class="labels"><strong>País: </strong><label class="info-text">-</label></label>
                @endif

                @if (isset($intermediario->provincia))
                <label class="labels"><strong>Provincia: </strong>{{$provincia->nombre}}</label>
                @else
                <label class="labels"><strong>Provincia: </strong><label class="info-text">-</label></label>
                @endif

                @if (isset($intermediario->localidad))
                <label class="labels"><strong>Ciudad: </strong>{{$localidad->nombre}}</label>
                @else
                <label class="labels"><strong>Ciudad: </strong><label class="info-text">-</label></label>
                @endif

                @if (isset($intermediario->cp))
                <label class="labels"><strong>CP: </strong>{{$intermediario->cp}}</label>
                @else
                <label class="labels"><strong>CP: </strong><label class="info-text">-</label></label>
                @endif

                @if (isset($intermediario->domicilio))
                <label class="labels"><strong>Dirección: </strong>{{$intermediario->domicilio}}</label>
                @else
                <label class="labels"><strong>Dirección: </strong><label class="info-text">-</label></label>
                @endif
                <hr>
                <div class="form-title">Contactos <a
                        href="{{ action('IntermediarioController@contact', $intermediario->cuit) }}"><button
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
                <label class="labels info-text"><i class="fa fa-exclamation-circle"></i> No se encontraron contactos</label>
                @endif
                <hr>
                <div class="center-of-page"><a onclick="warning( '{{$intermediario->cuit}}' , 'intermediario');"><button
                            class="delete-button" title="Eliminar"><i class="fa fa-trash"></i>
                            Eliminar</button></a>
                </div>
            </div>
            @include('sweet::alert')
</body>
@endsection
