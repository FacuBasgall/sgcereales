<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Contacto extends Model
{
    protected $table = 'tipo_contacto';
    protected $primaryKey = 'idTipoContacto';
    public $timestamps = false;

    protected $fillable = ['descripcion'];

    public function corredor(){
        return $this->belongsToMany('App\Corredor', 'Corredor_Contacto', 'idTipoContacto', 'cuit');
    }
    public function cargador(){
        return $this->belongsToMany('App\Cargador', 'Cargador_Contacto', 'idTipoContacto', 'cuit');
    }
    public function destino(){
        return $this->belongsToMany('App\Destino', 'Destino_Contacto', 'idTipoContacto', 'cuit');
    }
}
