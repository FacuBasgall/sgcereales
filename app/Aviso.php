<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    protected $table = 'aviso';
    protected $primaryKey = 'idAviso';
    public $timestamps = false;
    protected $fillable = ['idProducto', 'idCorredor', 'idEntregador', 'estado', 'observacion', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];
    
    public function corredor(){
        return $this->belongsTo('App\Corredor', 'idCorredor', 'idAviso');
    }
    public function aviso_producto(){
        return $this->hasOne('App\Aviso_Producto', 'idAviso', 'idAviso');
    }
    public function carga(){
        return $this->hasOne('App\Carga', 'idAviso', 'idAviso'); // Parametros: Modelo, FK de este Modelo en el otro, PK de este modelo
    }
    public function aviso_entregador(){
        return $this->hasOne('App\Aviso_Entregador', 'idAviso', 'idAviso');
    }
}
