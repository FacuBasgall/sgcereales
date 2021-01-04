@extends('layout.master-admin')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home-admin.css') }}">
</head>
<body>
    <div class="titulo">
        <h1>¡Bienvenido Administrador!</h1>
    </div>
    <div class="img-admin">
        <img src="{{ URL::to('/image/SGC.jpg') }}">
    </div>
</body>

@endsection
