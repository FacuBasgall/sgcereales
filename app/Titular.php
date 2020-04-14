<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Titular extends Model
{
    protected $table = 'titular';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'condIva', 'dgr', 'cp', 'domicilio', 'localidad', 'provincia', 'pais', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function titular_contacto(){
        return $this->hasMany('App\Titular_Contacto', 'cuit', 'cuit');
    } 
    public function condicion_iva(){
        return $this->belongsTo('App\Condicion_IVA', 'condIva', 'cuit');
    }
    public function carga(){
        return $this->hasMany('App\Carga', 'idTitular', 'cuit');
    }
}
