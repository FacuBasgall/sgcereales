<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargador extends Model
{
    protected $table = 'cargador';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'condIva', 'dgr', 'cp', 'domicilio', 'localidad', 'provincia', 'pais', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function cargador_contacto(){
        return $this->hasMany('App\Cargador_Contacto', 'cuit', 'cuit');
    } 
    public function condicion_iva(){
        return $this->belongsTo('App\Condicion_IVA', 'condIva', 'cuit');
    }
    public function carga(){
        return $this->hasMany('App\Carga', 'idCargador', 'cuit');
    }
}
