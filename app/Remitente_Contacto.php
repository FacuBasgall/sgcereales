<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remitente_Contacto extends Model
{
    protected $table = 'remitente_contacto';
    public $timestamps = false;
    protected $fillable = ['cuit', 'contacto', 'tipo'];


    public function remitente(){
        return $this->belongsTo('App\Remitente_Comercial', 'cuit', 'cuit');
    }
    public function tipo_contacto(){
        return $this->belongsTo('App\Tipo_Contacto', 'idTipoContacto', 'tipo');
    }
}
