<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table = 'destinatario';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'condIva', 'dgr', 'cp', 'domicilio', 'localidad', 'provincia', 'pais'];

    public function tipo_contacto(){
        return $this->belongsToMany('App\Tipo_Contacto', 'Destino_Contacto', 'cuit', 'idTipoContacto');
    }
    public function condicion_iva(){
        return $this->belongsTo('App\Condicion_IVA', 'idCondIva', 'cuit');
    }
    public function descarga(){
        return $this->hasMany('App\Descarga', 'idDescarga', 'cuit');
    }
}
