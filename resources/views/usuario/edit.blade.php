@extends('layout.master')
@section('content')
@parent
<div class="content-title m-x-auto">
    <i class="fa fa-address-card"></i> <a href="{{ action('UsuarioController@show') }}">Datos personales</a> <i
        class="fa fa-chevron-right"></i> Editar datos personales
</div>
<div class="container">
    <div class="card">
        <div class="box">
            <form action="{{action('UsuarioController@update')}}" method="POST" autocomplete="off">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <label for="nombre">
                    <span>Nombre y apellido*:</span>
                    <input type="text" name="nombre" id="nombre" class="common-input" value="{{auth()->user()->nombre}}"
                        maxlength="200" required>
                </label>
                <label for="cuit">
                    <span>CUIT: </span>
                    <input type="number" name="cuit" id="cuit" class="common-input" value="{{auth()->user()->cuit}}"
                        readonly>
                </label>
                <br>
                <label for="descripcion">
                    <p class="form-title">Descripción*:</p>
                    <textarea name="descripcion" id="descripcion" value="{{auth()->user()->descripcion}}" class="observation-box"
                        style="height:80px;" placeholder="Ingrese una descripcion" cols="150">{{auth()->user()->descripcion}}</textarea>
                </label>
                <div class="center-of-page"><button type="submit" class="save-button"><i class="fa fa-check"></i>
                        Guardar</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
