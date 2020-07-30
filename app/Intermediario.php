<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intermediario extends Model
{
    protected $table = 'intermediario';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function intermediario_contacto(){
        return $this->hasMany('App\Intermediario_Contacto', 'cuit', 'cuit');
    }

    public function aviso(){
        return $this->hasMany('App\Aviso', 'idIntermediario', 'cuit');
    }
}