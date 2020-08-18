@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/header.css') }}">
</head>

<body style="background:url(/image/cargador-camion.jpg) no-repeat center center fixed">
    <div class="card-header">
        <label class="title col-md-8 col-form-label"><b>Añadir remitente</b></label>
    </div>
    <div class="container">
        <div class="card" style="height:800px;width:450px;">
            <div class="box">
                <form action="{{action('RemitenteController@store')}}" method="POST">
                    {{ csrf_field() }}
                    <label for="nombre">
                        <span>Nombre y apellido:*</span>
                        <input type="text" value="{{old('nombre')}}" name="nombre" id="nombre" class="input" required>
                    </label>
                    <label for="cuit">
                        <span>CUIT:*</span>
                        <input type="text" value="{{old('cuit')}}" name="cuit" id="cuit" class="input" min="0"
                            max="999999999999999" required>
                    </label>
                    <label for="dgr">
                        <span>DGR: </span>
                        <input type="text" value="{{old('dgr')}}" name="dgr" id="dgr" class="input">
                    </label>
                    <label for="iva">
                        <span>IVA:*</span>
                        <select name="iva" class="input" required>
                            <option value="" selected disabled hidden></option>
                            @foreach ($iva as $condicion)
                            <option value="{{ $condicion->idCondIva }}"
                                {{old('iva') == $condicion->idCondIva ? 'selected':''}}>{{ $condicion->descripcion }}
                            </option>
                            @endforeach
                        </select>
                    </label>
                    <label for="cp">
                        <span>Codigo postal: </span>
                        <input type="text" value="{{old('cp')}}" name="cp" id="cp" class="input">
                    </label>
                    <label for="pais">
                        <span>Pais: </span>
                        <input type="text" value="{{old('pais')}}" name="pais" id="pais" class="input">
                    </label>
                    <label for="provincia">
                        <span>Provincia: </span>
                        <input type="text" value="{{old('provincia')}}" name="provincia" id="provincia" class="input">
                    </label>
                    <label for="localidad">
                        <span>Localidad: </span>
                        <input type="text" value="{{old('localidad')}}" name="localidad" id="localidad" class="input">
                    </label>
                    <label for="domicilio">
                        <span>Domicilio: </span>
                        <input type="text" value="{{old('domicilio')}}" name="domicilio" id="domicilio" class="input">
                    </label>
                    <button type="submit" class="save-button" style="position:relative; left:40%; margin-top:10px"><i
                            class="fa fa-check"></i> Guardar</button>
                    <a href="{{ action('RemitenteController@index') }}"><button type="button" class="back-button"
                            title="Volver" style="position: relative; right: 40%; margin-top:10px"><i
                                class="fa fa-arrow-left"></i> Volver</button></a>
                </form>
            </div>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection
