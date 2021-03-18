@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home-admin.css') }}">
</head>

<body>
    <div class="home">
        <div class="titulo">
            <h1>¡Bienvenido Usuario!</h1>
        </div>
        <div class="img-admin">
            <img src="{{ URL::to('/image/SGC.jpg') }}">
        </div>
        <div>
</body>

@endsection