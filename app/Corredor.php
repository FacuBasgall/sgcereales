<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corredor extends Model
{
    protected $table = 'corredor';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];
    
    public function aviso(){
        return $this->hasMany('App\Aviso', 'idCorredor', 'cuit');
    }
    public function corredor_contacto(){
        return $this->hasMany('App\Corredor_Contacto', 'cuit', 'cuit');
    } 
}
