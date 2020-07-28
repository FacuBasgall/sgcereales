@extends('layout.master')
@section('content')
	@parent
    <head>
        <!-- Links de dataTable -->
    <link rel="stylesheet" href="{!! asset('datatable/jquery.dataTables.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('datatable/dataTables.bootstrap4.min.css') !!}">
    <script src="{{ asset('datatable/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/dataTables.bootstrap4.min.js') }}"></script>
    </head>
    <body>
    <div class="cuadro">
    <div class="card">
    <div class="card-header">
    <label class="title col-md-8 col-form-label"><b>Listado de Avisos</b></label>
    <a href="{{ action('AvisoController@create') }}" ><button class="plus-button" title="Crear Aviso"><i class="fa fa-plus"></i> Crear Aviso</button></a>
    </div>
    <div class="card-body border">
        <table id="idDataTable" class="table table-striped" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Titular</th>
                    <th>Procedencia</th>
                    <th>Destinatario</th>
                    <th>Destino</th>
                    <th>Fecha de Creacion</th>
                    <th>Estado</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                @foreach($avisos as $aviso)
                <tr>
                    <td>{{ $aviso->idAviso }}</td>
                    @foreach ($productos as $producto)
                        @if ($producto->idProducto == $aviso->idProducto)
                            <td>{{$producto->nombre}}</td>
                        @endif
                    @endforeach
                    @foreach ($titulares as $titular)
                        @if ($titular->cuit == $aviso->idTitularCartaPorte)
                            <td>{{ $titular->nombre }}</td>
                        @endif
                    @endforeach
                    <td>{{$aviso->localidadProcedencia}} ({{$aviso->provinciaProcedencia}})</td>
                    @foreach ($destinatarios as $destinatario)
                        @if ($destinatario->cuit == $aviso->idDestinatario)
                            <td>{{ $destinatario->nombre }}</td>
                        @endif
                    @endforeach
                    <td>{{$aviso->lugarDescarga}}</td>
                    @foreach ($avisos_entregadores as $aviso_entregador)
                        @if ($aviso_entregador->idAviso == $aviso->idAviso)
                            <td>{{$aviso_entregador->fecha}}</td>
                        @endif
                    @endforeach
                    @if ($aviso->estado == true)
                        <td style="color: green;">Terminado</td>
                    @else
                        <td style="color: red;">Pendiente</td>
                    @endif
                    <td>
                        <a onclick="warning( '{{$aviso->idAviso}}' , 'aviso');"><button class="delete-button" title="Eliminar" style="padding: 7px; margin:0px;"><i class="fa fa-trash"></i></button></a>
                        <a href="{{ action('AvisoController@edit', $aviso->idAviso) }}"><button class="edit-button" title="Editar" style="padding: 7px; margin:0px;"><i class="fa fa-pencil"></i></button></a>
                        <a href="{{ action('AvisoController@show', $aviso->idAviso) }}"><button class="show-button" title="Ver más" style="padding: 7px; margin:0px"><i class="fa fa-eye"></i></button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        </div>
        </div>
        @include('sweet::alert')
        </body>
<script>
        $(document).ready(function() {
        $('#idDataTable').DataTable();
        } );

</script>
<style>
    .title {
        font-size: 19px;
    }

    .card-header {
        background-color: #ffffffd2;
    }
</style>
@stop


