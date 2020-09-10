@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/prueba-show.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AvisoController@index') }}">Avisos</a> /
            Detalle del aviso</label>
    </div>
    <div class="container">
        <div class="card">
            <div class="box">
                <div class="header-title"><strong>
                        <div>Nro Aviso: {{$aviso->nroAviso}}</div>
                    </strong></div>
                <hr>
                <div class="form-title">Datos del aviso <a
                        href="{{ action('AvisoController@edit', $aviso->idAviso) }}"><button class="small-edit-button"
                            title="Editar datos del aviso"><i class="fa fa-pencil"></i></button></a></div>
                @if(isset($aviso->entregador))
                <label class="labels"><strong>Entregador: </strong>{{$aviso->entregador}}</label>
                @else
                <label class="labels"><strong>Entregador: </strong>{{$entregador->nombre}}</label>
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
                @if(!empty($arrayCarga))
                @foreach ($arrayCarga as $carga)
                <div class="flex-container">
                    <div class="flex-child left-bar">
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
                    <div class="flex-child left-bar">
                        <div class="form-title">Descarga</div>
                        @if($descarga->fecha != "-")
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
                        No existe una descarga asociada
                        <div><a href="{{ action('DescargaController@create', $carga->idCarga) }}"><button
                                    class="show-plus-button" title="Añadir descarga" style="margin:5px"><i
                                        class="fa fa-plus"></i></button></a>
                        </div>
                        @endif
                        @endif
                        @endforeach
                        <div><a href="{{ action('CargaController@edit', $carga->idCarga) }}"><button
                                    class="small-edit-button" title="Editar"><i class="fa fa-pencil"></i></button></a>
                        </div>
                    </div>
                </div>
                @endforeach
                <hr>
                @endif
                @if (isset($aviso->observacion))
                <div class="form-title">Observación </div>
                <label class="labels">{{$aviso->observacion}} </label>
                @else
                <div class="form-title">Observación</div>
                <label class="labels">Sin observaciones</label>
                @endif
                <hr>
                @php
                $estado = "";
                @endphp


                <div class="form-title">Estado: @if($aviso->estado == true) <label style="color:green;">
                        {{$estado = "Terminado"}} </label> @else <label style="color:red;"> {{$estado = "Pendiente"}}
                    </label>@endif
                    <a href="{{ action('AvisoController@change_status', $aviso->idAviso) }}"><button type="button"
                            class="change-state-button" title="Cambiar estado"><i class="fa fa-exchange"></i> Cambiar
                            estado</button></a>
                </div>
                <hr>
                <div class="center-of-page">
                    <a onclick="warning( '{{$aviso->idAviso}}' , 'aviso');"><button class="delete-button"
                            title="Eliminar" style="margin:5px"><i class="fa fa-trash"></i> Eliminar</button></a>
                    <a href="{{ action('CargaController@create', $aviso->idAviso) }}"><button class="show-plus-button"
                            title="Añadir carga" style="margin:5px"><i class="fa fa-plus"></i> Añadir carga</button></a>
                </div>
                <hr>
                <div class="center-of-page">
                    <a href="{{ action('AvisoController@export_excel', $aviso->idAviso) }}"><button
                            class="export-button"><i class="fa fa-file-excel-o"></i> Exportar
                            Excel</button></a>
                    <a href="{{ action('AvisoController@export_pdf', $aviso->idAviso) }}"><button
                            class="export-button"><i class="fa fa-file-pdf-o"></i> Exportar
                            PDF</button></a>
                    <a onclick="warningSendEmails( '{{$aviso->idAviso}}');"><button class="export-button"><i
                                class="fa fa-share"></i> Enviar correos</button></a>
                </div>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
