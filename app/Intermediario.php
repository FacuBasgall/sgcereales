<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intermediario extends Model
{
    protected $table = 'intermediario';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'condIva', 'dgr', 'cp', 'domicilio', 'localidad', 'provincia', 'pais', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function intermediario_contacto(){
        return $this->hasMany('App\Intermediario_Contacto', 'cuit', 'cuit');
    }

    public function condicion_iva(){
        return $this->belongsTo('App\Condicion_IVA', 'condIva', 'cuit');
    }

    public function aviso(){
        return $this->hasMany('App\Aviso', 'idIntermediario', 'cuit');
    }

    public function filtro(){
        return $this->belongsTo('App\Filtro', 'idIntermediario', 'cuit');
    }
}
