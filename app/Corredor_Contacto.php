<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corredor_Contacto extends Model
{
    protected $table = 'corredor_contacto';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['cuit', 'contacto', 'tipo'];


    public function corredor(){
        return $this->belongsTo('App\Corredor', 'cuit', 'cuit');
    }
    public function tipo_contacto(){
        return $this->belongsTo('App\Tipo_Contacto', 'idTipoContacto', 'tipo');
    }
}
