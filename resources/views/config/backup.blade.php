@extends('config.index')
@section('option')
@parent

<div class="content-title m-x-auto">
    <i class="fa fa-database"></i> Realizar copia de resguardo
</div>
<br>
<a href="{{ action('ConfigController@run_backup') }}"><button class="export-button"><i class="fa fa-floppy-o"></i>
        Guardar</button></a>

@endsection
