@extends('layout.master')
@section('content')
@parent

<head>
    <script type="text/javascript" src="{{ asset('js/select-localidad.js') }}"></script>
</head>

<body>
    <div>
        <form action="{{action('ReporteController@find')}}" method="GET">
            {{ csrf_field() }}
            <label for="fechaDesde">
                <span>Fecha desde:</span>
                <input type="date" value="{{old('fechaDesde')}}" name="fechaDesde" id="fechaDesde" class="input">
            </label>
            <label for="fechaHasta">
                <span>Fecha hasta:</span>
                <input type="date" value="{{old('fechaHasta')}}" name="fechaHasta" id="fechaHasta" class="input">
            </label>
            <label for="titular">
                <span>Titular Carta Porte:</span>
                <select name="titular" id="titular" class="input" style="width:100%">
                    <option value="" selected disabled hidden></option>
                    @foreach ($titulares as $titular)
                    <option value="{{ $titular->cuit }}" {{old('titular') == $titular->cuit ? 'selected':''}}>
                        {{$titular->nombre}}</option>
                    @endforeach
                </select>
                <script>
                $.fn.select2.defaults.set('language', 'es');
                $("#titular").select2({
                    placeholder: 'Seleccione',
                    dropdownAutoWidth: true,
                });
                </script>
            </label>
            <label for="intermediario">
                <span>Intermediario:</span>
                <select name="intermediario" id="intermediario" class="input" style="width:100%">
                    <option value="" selected></option>
                    @foreach ($intermediarios as $intermediario)
                    <option value="{{ $intermediario->cuit }}"
                        {{old('intermediario') == $intermediario->cuit ? 'selected':''}}>
                        {{$intermediario->nombre}}</option>
                    @endforeach
                </select>
                <script>
                $.fn.select2.defaults.set('language', 'es');
                $("#intermediario").select2({
                    placeholder: 'Seleccione',
                    dropdownAutoWidth: true,
                });
                </script>
            </label>
            <label for="remitente">
                <span>Remitente Comercial:</span>
                <select name="remitente" id="remitente" class="input" style="width:100%">
                    <option value="" selected disabled hidden></option>
                    @foreach ($remitentes as $remitente)
                    <option value="{{ $remitente->cuit }}" {{old('remitente') == $remitente->cuit ? 'selected':''}}>
                        {{$remitente->nombre}}</option>
                    @endforeach
                </select>
                <script>
                $.fn.select2.defaults.set('language', 'es');
                $("#remitente").select2({
                    placeholder: 'Seleccione',
                    dropdownAutoWidth: true,
                });
                </script>
            </label>
            <label for="corredor">
                <span>Corredor:</span>
                <select name="corredor" id="corredor" class="input" style="width:100%">
                    <option value="" selected disabled hidden></option>
                    @foreach ($corredores as $corredor)
                    <option value="{{ $corredor->cuit }}" {{old('corredor') == $corredor->cuit ? 'selected':''}}>
                        {{$corredor->nombre}}</option>
                    @endforeach
                </select>
                <script>
                $.fn.select2.defaults.set('language', 'es');
                $("#corredor").select2({
                    placeholder: 'Seleccione',
                    dropdownAutoWidth: true
                });
                </script>
            </label>
            <label for="destinatario">
                <span>Destinatario:</span>
                <select name="destinatario" id="destinatario" class="input" style="width:100%">
                    <option value="" selected disabled hidden></option>
                    @foreach ($destinatarios as $destinatario)
                    <option value="{{ $destinatario->cuit }}"
                        {{old('destinatario') == $destinatario->cuit ? 'selected':''}}>{{$destinatario->nombre}}
                    </option>
                    @endforeach
                </select>
                <script>
                $.fn.select2.defaults.set('language', 'es');
                $("#destinatario").select2({
                    placeholder: 'Seleccione',
                    dropdownAutoWidth: true,
                });
                </script>
            </label>
            <label for="entregador">
                <span>Entregador:</span>
                <input type="text" value="{{old('entregador')}}" name="entregador" id="entregador" class="input">
            </label>
            <label for="producto">
                <span>Producto:</span>
                <select name="producto" class="input" id="producto" style="width:100%">
                    <option value="" selected disabled hidden></option>
                    @foreach ($productos as $producto)
                    <option value="{{ $producto->idProducto }}"
                        {{old('producto') == $producto->idProducto ? 'selected':''}}> {{$producto->nombre}}</option>
                    @endforeach
                </select>
                <script>
                $.fn.select2.defaults.set('language', 'es');
                $("#producto").select2({
                    placeholder: 'Seleccione',
                    dropdownAutoWidth: true,
                });
                </script>
            </label>
            <button type="submit">Buscar</button>
            <hr>
    </div>
    <div>
        @yield('result')
    </div>
    @include('sweet::alert')
</body>
@endsection
