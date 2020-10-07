@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AvisoController@index') }}">Avisos</a> <i class="fa fa-chevron-right"></i> Detalle del aviso</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="header-title"><strong>
                        <div>Nro Aviso: {{$aviso->nroAviso}}</div>
                    </strong></div>
                <hr>
                <div class="form-title"><strong>Datos del aviso</strong> <a href="{{ action('AvisoController@edit', $aviso->idAviso) }}"><button class="small-edit-button" title="Editar datos del aviso"><i class="fa fa-pencil"></i></button></a></div>
                <div class="info-margin">
                @if(isset($aviso->entregador))
                <label class="labels"><strong>Entregador: </strong>{{$aviso->entregador}}</label>
                @else
                <label class="labels"><strong>Entregador: </strong>{{auth()->user()->nombre}}</label>
                @endif
                <label class="labels"><strong>Producto: </strong>{{$producto->nombre}}</label>
                <label class="labels"><strong>Titular: </strong>{{$titular->nombre}}</label>
                @if (isset($intermediario->nombre))
                <label class="labels"><strong>Intermediario: </strong>{{$intermediario->nombre}}</label>
                @else
                <label class="labels"><strong>Intermediario: </strong>-</label>
                @endif
                <label class="labels"><strong>Remitente Comercial: </strong>{{$remitente->nombre}}</label>
                <label class="labels"><strong>Lugar de procedencia: </strong>{{$localidad->nombre}},
                    {{$provincia->nombre}}</label>
                <label class="labels"><strong>Corredor: </strong>{{$corredor->nombre}}</label>
                <label class="labels"><strong>Destinatario: </strong>{{$destino->nombre}}</label>
                <label class="labels"><strong>Destino: </strong>{{$aviso->lugarDescarga}}</label>
                <hr>
                <div class="form-title"><strong>Cargas/Descargas</strong> <a href="{{ action('CargaController@create', $aviso->idAviso) }}"><button style="padding:9px 10px" class="small-plus-button" title="Añadir carga"><i class="fa fa-plus"></i></button></a></div>
                @if(!empty($arrayCarga))
                @php $cant= 1 @endphp
                @foreach ($arrayCarga as $carga)
                <div class="form-title" style="margin-left:3%;">N° {{$cant}} carga/descarga <a href="{{ action('CargaController@edit', $carga->idCarga) }}"><button class="small-edit-button" title="Editar"><i class="fa fa-pencil"></i></button></a></div>
                <div class="flex-container">
                    <div class="flex-child left-bar" style="margin-left:3%;">
                        <div class="form-title">Carga</div>
                        <label class="labels"><strong>Fecha:
                            </strong>{{date("d/m/Y", strtotime($carga->fecha))}}</label>
                        <label class="labels"><strong>Número de carta porte: </strong>
                            @if ($carga->nroCartaPorte != NULL) {{$carga->nroCartaPorte}}
                            @else - @endif </label>
                        <label class="labels"><strong>Matricula del camión: </strong>
                            @if ($carga->matriculaCamion != NULL) {{$carga->matriculaCamion}}
                            @else - @endif </label>
                        <label class="labels"><strong>Kilos Cargados: </strong>{{$carga->kilos}}</label>
                    </div>
                    @foreach ($arrayDescarga as $descarga)
                    @if($descarga->idCarga == $carga->idCarga)
                    <div class="flex-child">
                        @if($descarga->fecha != "-")
                        <div class="form-title">Descarga</div>
                        <label class="labels"><strong>Fecha:
                            </strong>{{date("d/m/Y", strtotime($descarga->fecha))}}</label>
                        <label class="labels"><strong>Brutos (KG): </strong>{{$descarga->bruto}}</label>
                        <label class="labels"><strong>Tara (KG): </strong>{{$descarga->tara}}</label>
                        <label class="labels"><strong>Neto (KG): </strong>{{$descarga->bruto - $descarga->tara}}</label>
                        <label class="labels"><strong>Humedad: </strong>{{$descarga->humedad}}</label>
                        <label class="labels"><strong>Merma (%): </strong>
                            @if ($descarga->merma != NULL) {{$descarga->merma}}
                            @else No aplica @endif </label>
                        <label class="labels"><strong>Merma (KG):
                            </strong>{{round(($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))}}</label>
                        <label class="labels"><strong>Neto Final (KG):
                            </strong>{{round(($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100)))}}</label>
                        <label class="labels"><strong>Diferencia (KG):
                            </strong>{{round((($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))) - $carga->kilos)}}</label>
                        <label class="labels"><strong>PH: </strong>
                            @if ($descarga->ph != NULL) {{$descarga->ph}} @else - @endif</label>
                        <label class="labels"><strong>Proteina: </strong>
                            @if ($descarga->proteina != NULL) {{$descarga->proteina}}
                            @else - @endif</label>
                        <label class="labels"><strong>Calidad: </strong>
                            @if ($descarga->calidad != NULL) {{$descarga->calidad}} @else - @endif </label>
                        @else
                        <div class="form-title">Descarga <a href="{{ action('DescargaController@create', $carga->idCarga) }}"><button class="small-plus-button" style="padding:7px 8px 7px 8px; font-size:14px;" title="Añadir descarga"><i class="fa fa-plus"></i></button></a></div>
                        <label class="labels info-text"><i class="fa fa-exclamation-circle"></i> No existe una descarga asociada</label>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
                <hr>
                @php $cant++ @endphp
                @endforeach
                @else
                <div class="info-margin"><label class="labels info-text"><i class="fa fa-exclamation-circle"></i> Haga click en el + para ingresar una nueva carga</label></div>
                <hr>
                @endif
                <div class="form-title"><strong>Observación</strong></div>
                @if (isset($aviso->observacion))
                <div class="info-margin"><label class="labels">{{$aviso->observacion}} </label></div>
                @else
                <div class="info-margin"><label class="labels info-text"><i class="fa fa-exclamation-circle"></i> Sin observaciones</label></div>
                @endif
                <hr>
                @php
                $estado = "";
                @endphp


                <div class="form-title"><strong>Estado: </strong>@if($aviso->estado == true)<label style="color:green;">
                            {{$estado = "Terminado"}} </label> @else <label style="color:red;"> {{$estado = "Pendiente"}}
                        </label>@endif
                    <a class="change-state-button" href="{{ action('AvisoController@change_status', $aviso->idAviso) }}"><i class="fa fa-refresh"></i></a>
                </div>
                <hr>
                <div class="end-of-the-page">
                    <a onclick="warning( '{{$aviso->idAviso}}' , 'aviso');"><button class="delete-button" title="Eliminar"><i class="fa fa-trash"></i> Eliminar</button></a>
                    <a href="{{ action('AvisoController@export_excel', $aviso->idAviso) }}"><button class="export-button"><i class="fa fa-file-excel-o"></i> Exportar
                            Excel</button></a>
                    <a href="{{ action('AvisoController@export_pdf', $aviso->idAviso) }}"><button class="export-button"><i class="fa fa-file-pdf-o"></i> Exportar
                            PDF</button></a>
                    <a onclick="warningSendEmails( '{{$aviso->idAviso}}');"><button class="export-button"><i class="fa fa-envelope"></i> Enviar</button></a>
                </div>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
