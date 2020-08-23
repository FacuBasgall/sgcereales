<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destino_Contacto extends Model
{
    protected $table = 'destinatario_contacto';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['cuit', 'contacto', 'tipo'];

    public function destino(){
        return $this->belongsTo('App\Destino', 'cuit', 'cuit');
    }
    public function tipo_contacto(){
        return $this->belongsTo('App\Tipo_Contacto', 'idTipoContacto', 'tipo');
    }
}
