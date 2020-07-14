<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remitente_Comercial extends Model
{
    protected $table = 'remitente_comercial';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function remitente_contacto(){
        return $this->hasMany('App\Remitente_Contacto', 'cuit', 'cuit');
    }

    public function aviso(){
        return $this->hasMany('App\Aviso', 'idRemitenteComercial', 'cuit');
    }
}
