@extends('layout.master')
@section('content')
    @parent
    <strong>ID Aviso: </strong>{{$aviso->idAviso}}<br>
    <strong>Producto: </strong>{{$producto->nombre}}<br>
    <strong>Entregador: </strong>{{$entregador->descripcion}}<br>
    <strong>Titular: </strong>{{$titular->nombre}}<br>
    @if (isset($intermediario->nombre))
        <strong>Intermediario: </strong>{{$intermediario->nombre}}<br>
    @endif
    <strong>Remitente Comercial: </strong>{{$remitente->nombre}}<br>
    <strong>Lugar de procedencia: </strong>{{$aviso->localidadProcedencia}}, {{$aviso->provinciaProcedencia}}<br>
    <strong>Corredor: </strong>{{$corredor->nombre}}<br>
    <strong>Destinatario: </strong>{{$destino->nombre}}<br>
    <strong>Lugar de destino: </strong>{{$aviso->lugarDescarga}}

    @foreach ($cargas as $carga)
        @php $control = false @endphp
        <br><br><hr>
        Información de la carga:<br>
        <strong>Fecha de la Carga: </strong>{{$carga->fecha}}<br>
        @if (isset($carga->nroCartaPorte))
            <strong>Numero de carta porte: </strong>{{$carga->nroCartaPorte}}<br>
        @endif
        @if (isset($carga->matriculaCamion))
            <strong>Matricula del camion: </strong>{{$carga->matriculaCamion}}<br>
        @endif
        <strong>KG Cargados: </strong>{{$carga->kilos}}<br>
        <br><hr>

        @foreach ($descargas as $descarga)
            @if ($descarga->idCarga == $carga->idCarga)
                @php $control = true @endphp
                Información de la descarga:<br>
                <strong>Fecha de la Descarga: </strong>{{$descarga->fecha}}<br>
                <strong>KG Brutos: </strong>{{$descarga->bruto}}<br>
                <strong>KG Tara: </strong>{{$descarga->tara}}<br>
                <strong>KG Netos: </strong>{{$descarga->bruto - $descarga->tara}}<br>
                <strong>Humedad: </strong>{{$descarga->humedad}}<br>
                @if (isset($descarga->merma))
                    <strong>Merma (%): </strong>{{$descarga->merma}}<br>
                @else
                    <strong>Merma (%): </strong>No posee<br>
                @endif
                <strong>Merma (KG): </strong>{{round(($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))}}<br>
                <strong>KG Neto Final: </strong>{{round(($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100)))}}<br>
                <strong>KG Diferencia: </strong>{{round((($descarga->bruto - $descarga->tara) - (($descarga->bruto - $descarga->tara) * ($descarga->merma / 100))) - $carga->kilos)}}<br>
                @if (isset($descarga->ph))
                    <strong>PH : </strong>{{$descarga->ph}}<br>
                @else
                    <strong>PH : </strong>No ingresado<br>
                @endif
                @if (isset($descarga->proteina))
                    <strong>Proteina : </strong>{{$descarga->proteina}}<br>
                @else
                    <strong>Proteina : </strong>No ingresado<br>
                @endif
                @if (isset($descarga->calidad))
                    <strong>Calidad : </strong>{{$descarga->calidad}}<br>
                @else
                    <strong>Calidad : </strong>No ingresado<br>
                @endif
            @endif
        @endforeach
        @if ($control == false)
            Información de la descarga:<br>
            No existe una descarga asociada<br>
            <a href="{{ action('DescargaController@create', $carga->idCarga) }}"><button>Añadir</button></a>
        @endif
    @endforeach
    <br><hr>
    @if($aviso->estado == false)
        <strong>Estado: </strong><input type="radio" name="estado" value="Pendiente" checked/>Pendiente
        <a href="{{ action('AvisoController@change_status', $aviso->idAviso) }}">
        <input type="radio" name="estado" value="Terminado"/>Terminado<br></a>

    @else
        <strong>Estado: </strong><a href="{{ action('AvisoController@change_status', $aviso->idAviso) }}">
        <input type="radio" name="estado" value="Pendiente"/>Pendiente</a>
        <input type="radio" name="estado" value="Terminado" checked/>Terminado<br>
    @endif
    <a href="{{ action('AvisoController@index') }}"><button>Volver</button></a>
    <a href="{{ action('AvisoController@edit', $aviso->idAviso) }}"><button>Editar</button></a>
    <a href="{{ action('CargaController@create', $aviso->idAviso) }}"><button>Nueva carga</button></a>
    <a onclick="warning( '{{$aviso->idAviso}}' , 'aviso');"><button class="delete-button" title="Eliminar" style="padding: 7px; margin:0px;"><i class="fa fa-trash"></i></button></a>
    <br><br>
    @include('sweet::alert')

@endsection
