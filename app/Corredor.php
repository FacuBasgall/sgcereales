<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corredor extends Model
{
    protected $table = 'corredor';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function aviso(){
        return $this->hasMany('App\Aviso', 'idAviso', 'cuit');
    }
    public function tipo_contacto(){
        return $this->belongsToMany('App\Tipo_Contacto', 'Corredor_Contacto', 'cuit', 'idTipoContacto');
    }
}
