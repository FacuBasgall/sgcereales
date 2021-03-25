@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index-cards.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cortar-card.css') }}">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="card-header">
        <a class="title">Corredores</a>
        <div class="search-bar">
            <form class="{{action('CorredorController@index')}}" method="GET" autocomplete="off">
                {{ csrf_field() }}
                <input class="searchTerm" value="{{$query}}" type="search" placeholder="Buscar..." name="search" id="search">
                <button class="searchButton" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <a href="{{ action('CorredorController@create') }}"><button class="plus-button" title="Añadir corredor"><i
                    class="fa fa-plus"></i> Añadir</button></a>
    </div>
    <div class="container">
        @if(!empty($arrayCorredor) && $arrayCorredor->count())
        @foreach( $arrayCorredor as $key)
        <div class="card">
            <div class="box">
                <a class="title">
                    <div class="cortar">{{$key->nombre}}</div>
                </a>
                <p>CUIT: {{$key->cuit}}</p>
                <hr>
                </hr>
                <a href="{{ action('CorredorController@show', $key->cuit) }}"><button class="show-button"
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
    <div class="center-of-page">
    {!! $arrayCorredor->appends(Request::all())->links() !!}
    </div>
    @include('sweet::alert')
</body>
@endsection
