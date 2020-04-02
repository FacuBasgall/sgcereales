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
    <label class="col-md-8 col-form-label"><b>Listado de Avisos</b></b></label>
    <a href="{{ action('CargadorController@create') }}" ><button class="small-plus-button" title="Agregar aviso" style="font-family:sans-serif;"> Añadir</button></a>
    </div>
    <div class="card-body border">
        <table id="idDataTable" class="table table-striped" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Corredor</th>
                    <th>Entregador</th>
                    <th>Cargador</th>
                    <th>Fecha</th>
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
                    @foreach ($corredores as $corredor)
                        @if ($corredor->cuit == $aviso->idCorredor)
                            <td>{{ $corredor->nombre }}</td>
                        @endif
                    @endforeach
                    @foreach ($entregadores as $entregador)
                        @if ($entregador->idUser == $aviso->idEntregador)
                            <td>{{ $entregador->username }}</td>
                        @endif
                    @endforeach
                    @foreach ($cargas as $carga)
                        @if ($carga->idAviso == $aviso->idAviso)
                            @foreach ($cargadores as $cargador)
                                @if ($carga->idCargador == $cargador->cuit)
                                    <td>{{$cargador->nombre}}</td>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    @foreach ($avisos_entregadores as $aviso_entregador)
                        @if ($aviso_entregador->idAviso == $aviso->idAviso)
                            <td>{{ $aviso_entregador->fecha }}</td>
                        @endif
                    @endforeach
                    @if ($aviso->estado == true)
                        <td style="color: red;">Terminado</td>
                    @else
                        <td style="color: green;">Pendiente</td>
                    @endif
                    <td>
                        <a onclick="warning( '{{$aviso->idAviso}}' , 'aviso');"><button class="delete-button" title="Eliminar" style="padding: 7px; margin:0px;"><i class="fa fa-trash"></i></button></a>
                        <a onclick="failEdit('{{$aviso->idAviso}}' , 'aviso', '{{$aviso->estado}}');"><button class="edit-button" title="Editar" style="padding: 7px; margin:0px;"><i class="fa fa-pencil"></i></button></a> 
                        <a href="{{ action('AvisoController@show', $aviso->idAviso) }}"><button class="show-button" title="Ver más" style="padding: 7px; margin:0px"><i class="fa fa-eye"></i></button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        </div>
        </div>
        </body>
<script>
        $(document).ready(function() {
        $('#idDataTable').DataTable();
        } );

</script>
@stop

    
