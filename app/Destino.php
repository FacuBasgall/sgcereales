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

    public function destino_contacto(){
        return $this->hasMany('App\Destino_Contacto', 'cuit', 'cuit');
    } 
    public function condicion_iva(){
        return $this->belongsTo('App\Condicion_IVA', 'condIva', 'cuit');
    }
    public function descarga(){
        return $this->hasMany('App\Descarga', 'idDestinatario', 'cuit');
    }
}
