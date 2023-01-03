@extends('layout.master')
@section('content')
@parent

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/contact-form.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/show.css') }}">
</head>

<body>
    <div class="card-header">
        <label class="title col-md-8 col-form-label">
        <a href="{{action('LocalidadController@index')}}">Gestión de localidades</a>
            <i class="fa fa-chevron-right"></i> Añadir localidad</label>
    </div>
    <div class="container">
        <div class="form-card">
            <span class="form-title"><strong>Añadir localidad</strong></span><br>
            <form action="{{action('LocalidadController@store')}}" method="GET" autocomplete="off">
                {{ csrf_field() }}
                <label for="provincia" id="prov" style="display:; margin-right:20px;">
                    <span>Provincia*:</span>
                    <select name="provincia" id="provincia" class="common-input" required>
                        <option value="" selected disabled hidden></option>
                        @foreach ($provincias as $provincia)
                        <option value="{{ $provincia->id }}" {{old('provincia') == $provincia->id ? 'selected':''}}>
                            {{$provincia->nombre}}</option>
                        @endforeach
                    </select>
                    <script>
                        $.fn.select2.defaults.set('language', 'es');
                        $("#provincia").select2({
                            placeholder: 'Seleccione',
                            dropdownAutoWidth: true,
                            allowClear: true
                        });
                    </script>
                </label>
                <label for="domicilio">
                    <span>Localidad*:</span>
                    <input type="text" value="{{old('localidad')}}" name="localidad" id="localidad" class="common-input-address" maxlength="250" required>
                </label>
                <hr>
                <div class="center-of-page"> <button type="submit" class="save-button"><i class="fa fa-check"></i>
                        Añadir</button> </div>
            </form>
        </div>
    </div>
    @include('sweet::alert')
</body>
@endsection