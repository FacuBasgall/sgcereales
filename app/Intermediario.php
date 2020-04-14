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
    
    public function carga(){
        return $this->hasMany('App\Carga', 'idRemitente', 'cuit');
    }

    public function intermediario_contacto(){
        return $this->hasMany('App\Intermediario_Contacto', 'cuit', 'cuit');
    } 
}
