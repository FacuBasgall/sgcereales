<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    protected $table = 'aviso';
    protected $primaryKey = 'idAviso';
    public $timestamps = false;
    protected $fillable = ['idProducto', 'idCorredor', 'idEntregador', 'estado', 'observacion'];

    public function producto(){
        return $this->belongsTo('App\Producto', 'idProducto', 'idAviso');
    }
    /* public function cargador(){
        return $this->belongsTo('App\Cargador', 'cuit', 'idAviso');
    } */
    public function corredor(){
        return $this->belongsTo('App\Corredor', 'idCorredor', 'idAviso');
    }
    public function aviso_producto(){
        return $this->hasOne('App\Aviso_Producto', 'idAviso', 'idAviso');
    }
    public function carga(){
        return $this->hasOne('App\Carga', 'idCarga', 'idAviso');
    }
    //relacion con entregador

    /*
       CONTROLLER
        
        join para mandar a vista
        y para obtner -> 

        podria llamar a una funcion de otro control si esta en publica y creo un new control 

        $modelo->otromodelorelacionado->atributo SI ES DE UNO A UNO

        $var = Persona::where ();

    */
}
