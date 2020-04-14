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
}
