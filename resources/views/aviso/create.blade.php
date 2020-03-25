@extends('layout.master')
@section('content')
	@parent
    <form action="{{action('AvisoController@store')}}" method="POST">
		{{ csrf_field() }}
        


        <div class="form-group text-center">
            <button type="submit">Guardar</button>
        </div>
    </form>
    @endsection