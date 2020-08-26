@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/showProduct.css') }}">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Remitentes</b></label>
        <a href="{{ action('RemitenteController@create') }}"><button class="plus-button" title="Añadir remitente"><i
                    class="fa fa-plus"></i> Añadir</button></a>
    </div>
    <form class="{{action('RemitenteController@index')}}" method="GET">
        {{ csrf_field() }}
        <input type="search" placeholder="Buscar..." name="search" id="search">
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
    <div class="container">
        @if(!empty($arrayRemitente) && $arrayRemitente->count())
        @foreach( $arrayRemitente as $key)
        <div class="card">
            <div class="box">
                <div class="img">
                    <img src="{{ URL::to('/image/cargador-icon.jpg') }}">
                </div>
                <h2>{{$key->nombre}}</h2>
                <p>CUIT: {{$key->cuit}}</p>

                <hr>
                </hr>
                <a href="{{ action('RemitenteController@show', $key->cuit) }}"><button class="show-button"
                        style="position: relative; top: 15%;" title="Ver más"><i class="fa fa-eye"></i> Ver</button></a>
                <br><br>
                </a>
            </div>
        </div>
        @endforeach
        @else
        <tr>
            <td>No hay datos.</td>
        </tr>
        @endif
    </div>
    {!! $arrayRemitente->appends(Request::all())->links() !!}
    @include('sweet::alert')
</body>
@endsection
