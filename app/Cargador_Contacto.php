<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargador_Contacto extends Model
{
    protected $table = 'cargador_contacto';
    public $timestamps = false;
    protected $fillable = ['cuit', 'contacto', 'tipo'];

    public function cargador(){
        return $this->belongsTo('App\Cargador', 'cuit');
    }
    public function tipo_contacto(){
        return $this->belongsTo('App\Tipo_Contacto', 'tipo');
    }
}
