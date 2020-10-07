<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remitente_Comercial extends Model
{
    protected $table = 'remitente';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'condIva', 'dgr', 'cp', 'domicilio', 'localidad', 'provincia', 'pais', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function remitente_contacto(){
        return $this->hasMany('App\Remitente_Contacto', 'cuit', 'cuit');
    }

    public function condicion_iva(){
        return $this->belongsTo('App\Condicion_IVA', 'condIva', 'cuit');
    }

    public function aviso(){
        return $this->hasMany('App\Aviso', 'idRemitenteComercial', 'cuit');
    }

    public function filtro(){
        return $this->belongsTo('App\Filtro', 'idRemitente', 'cuit');
    }
}
