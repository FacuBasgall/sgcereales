@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common-buttons.css') }}">
</head>

<body style="background:url(/image/field.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><a href="{{ action('AvisoController@index') }}">Avisos</a> /
            Detalle del aviso</label>
    </div>
    <div class="container">
        <div class="card" style="width:530px;">
            <div class="box">
                <div class="header">
                    <h2>Nro Aviso: {{$aviso->nroAviso}}</h2>
                    @if(isset($aviso->entregador))
                    <strong>Entregador: </strong>{{$aviso->entregador}}<br>
                    @else
                    <strong>Entregador: </strong>{{$entregador->nombre}}<br>
                    @endif
                    <strong>Producto: </strong>{{$producto->nombre}}<br>
                    <strong>Titular: </strong>{{$titular->nombre}}<br>
                    @if (isset($intermediario->nombre))
                    <strong>Intermediario: </strong>{{$intermediario->nombre}}<br>
                    @else
                    <strong>Intermediario: </strong>-<br>
                    @endif
                    <strong>Remitente Comercial: </strong>{{$remitente->nombre}}<br>
                    <strong>Lugar de procedencia: </strong>{{$localidad->nombre}}, {{$provincia->nombre}}<br>
                    <strong>Corredor: </strong>{{$corredor->nombre}}<br>
                    <strong>Destinatario: </strong>{{$destino->nombre}}<br>
                    <strong>Destino: </strong>{{$aviso->lugarDescarga}}<br>
                    <a href="{{ action('AvisoController@edit', $aviso->idAviso) }}"><button class="edit-button"
                            title="Editar" style="margin:5px"><i class="fa fa-pencil"></i> Editar</button></a>

                    @foreach ($cargas as $carga)
                    @php $control = false @endphp
                    <br><br>
                    <hr style="width: 420px;">
                    <h2>Información de la carga</h2>
                    <strong>Fecha de la Carga: </strong>{{date("d/m/Y", strtotime($carga->fecha))}}<br>
                    @if (isset($carga->nroCartaPorte))
                    <strong>Numero de carta porte: </strong>{{$carga->nroCartaPorte}}<br>
                    @else
                    <strong>Numero de carta porte: </strong>-<br>
                    @endif
                    @if (isset($carga->matriculaCamion))
                    <strong>Matricula del camion: </strong>{{$carga->matriculaCamion}}<br>
                    @else
                    <strong>Matricula del camion: </strong>-<br>
                    @endif
                    <strong>Kilos Cargados: </strong>{{$carga->kilos}}<br>
                    <br>
                    <hr style="width: 420px;">

                    @foreach ($descargas as $descarga)
                    @if ($descarga->idCarga == $carga->idCarga)
                    @php $control = true @endphp
                    <h2>Información de la descarga</h2>
                    <strong>Fecha de la Descarga: </strong>{{date("d/m/Y", strtotime($descarga->fecha))}}<br>
                    <strong>Brutos (KG): </strong>{{$descarga->bruto}}<br>
                    <strong>Tara (KG): </strong>{{$descarga->tara}}<br>
                    <strong>Neto (KG): </strong>{{$descarga->bruto - $descarga->tara}}<br>
                    <strong>Humedad: </strong>{{$descarga->humedad}}<br>
                    @if (isset($descarga->merma))
                    <strong>Merma (%): </strong>{{$descarga->merma}}<br>
                    @else
                    <strong>Merma (%): </strong>No posee<br>
                    @endif
                    <strong>Merma (KG):
                    </strong>{{round(($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))}}<br>
                    <strong>Neto Final (KG):
                    </strong>{{round(($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100)))}}<br>
                    <strong>Diferencia (KG):
                    </strong>{{round((($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))) - $carga->kilos)}}<br>
                    @if (isset($descarga->ph))
                    <strong>PH: </strong>{{$descarga->ph}}<br>
                    @else
                    <strong>PH: </strong>-<br>
                    @endif
                    @if (isset($descarga->proteina))
                    <strong>Proteina: </strong>{{$descarga->proteina}}<br>
                    @else
                    <strong>Proteina: </strong>-<br>
                    @endif
                    @if (isset($descarga->calidad))
                    <strong>Calidad: </strong>{{$descarga->calidad}}<br>
                    @else
                    <strong>Calidad: </strong>-<br>
                    @endif
                    @endif
                    @endforeach
                    @if ($control == false)
                    <h2>Información de la descarga</h2><br>
                    No existe una descarga asociada<br>
                    <a href="{{ action('DescargaController@create', $carga->idCarga) }}"><button
                            class="show-plus-button" title="Añadir descarga" style="margin:5px"><i
                                class="fa fa-plus"></i> Añadir descarga</button></a>
                    @endif
                    <a href="{{ action('CargaController@edit', $carga->idCarga) }}"><button class="edit-button"
                            title="Editar" style="margin:5px"><i class="fa fa-pencil"></i> Editar</button></a>
                    @endforeach
                    <br>
                    <hr style="width: 420px;">
                    @if (isset($aviso->observacion))
                    <h2>Observación</h2>{{$aviso->observacion}}<br>
                    @else
                    <h2>Observación</h2>Sin observaciones<br>
                    @endif
                    <br>
                    <hr style="width: 420px;">

                    @php
                    $estado = "";
                    @endphp


                    <h2 style="display:inline;">Estado: @if($aviso->estado == true) <span class="finished">
                            {{$estado = "Terminado"}} </span> @else <span class="pending"> {{$estado = "Pendiente"}}
                        </span>@endif</h2>
                    <a href="{{ action('AvisoController@change_status', $aviso->idAviso) }}"><button type="button"
                            class="change-state-button" title="Cambiar estado" style="margin-left:90px"><i
                                class="fa fa-exchange"></i> Cambiar estado</button></a>
                    <hr style="width: 420px;">
                    <a onclick="warning( '{{$aviso->idAviso}}' , 'aviso');"><button class="delete-button"
                            title="Eliminar" style="margin:5px"><i class="fa fa-trash"></i> Eliminar</button></a>
                    <a href="{{ action('CargaController@create', $aviso->idAviso) }}"><button class="show-plus-button"
                            title="Añadir carga" style="margin:5px"><i class="fa fa-plus"></i> Añadir carga</button></a>
                    <hr style="width: 420px;">
                    <a href="{{ action('AvisoController@export_excel', $aviso->idAviso) }}"><button
                            class="export-button"><i class="fa fa-file-excel-o"></i> Exportar
                            Excel</button></a>
                    <a href="{{ action('AvisoController@export_pdf', $aviso->idAviso) }}"><button
                            class="export-button"><i class="fa fa-file-pdf-o"></i> Exportar
                            PDF</button></a>
                    <a onclick="warningSendEmails( '{{$aviso->idAviso}}');"><button class="export-button"><i
                                class="fa fa-share"></i> Enviar correos</button></a>
                    <br><br>
                </div>
            </div>
        </div>
        @include('sweet::alert')
</body>
@endsection
