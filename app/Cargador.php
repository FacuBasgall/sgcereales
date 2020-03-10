<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargador extends Model
{
    protected $table = 'cargador';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'condIva', 'dgr', 'cp', 'domicilio', 'localidad', 'provincia', 'pais'];

    /* public function aviso(){
        return $this->hasMany('App\Aviso', 'idAviso', 'cuit');
    } */
    public function tipo_contacto(){
        return $this->belongsToMany('App\Tipo_Contacto', 'Cargador_Contacto', 'cuit', 'idTipoContacto');
    }
    public function condicion_iva(){
        return $this->belongsTo('App\Condicion_IVA', 'idCondIva', 'cuit');
    }
    public function carga(){
        return $this->hasMany('App\Carga', 'idCarga', 'cuit');
    }
}
