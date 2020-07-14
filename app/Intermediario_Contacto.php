<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intermediario_Contacto extends Model
{
    protected $table = 'intermediario_contacto';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['cuit', 'contacto', 'tipo'];


    public function intermediario(){
        return $this->belongsTo('App\Intermediario', 'cuit', 'cuit');
    }
    public function tipo_contacto(){
        return $this->belongsTo('App\Tipo_Contacto', 'idTipoContacto', 'tipo');
    }
}
