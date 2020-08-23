<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condicion_IVA extends Model
{
    protected $table = 'condicion_iva';
    protected $primaryKey = 'idCondIva';
    public $timestamps = false;

    protected $fillable = ['descripcion'];

    public function destino(){
        return $this->hasMany('App\Destino', 'cuit', 'idCondIva');
    }

    public function titular(){
        return $this->hasMany('App\Titular', 'cuit', 'idCondIva');
    }

    public function corredor(){
        return $this->hasMany('App\Corredor', 'cuit', 'idCondIva');
    }

    public function intermediario(){
        return $this->hasMany('App\Intermediario', 'cuit', 'idCondIva');
    }

    public function remitente(){
        return $this->hasMany('App\Remitente_Comercial', 'cuit', 'idCondIva');
    }
}
