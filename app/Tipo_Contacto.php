<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Tipo_Contacto extends Model
{
    protected $table = 'tipo_contacto';
    protected $primaryKey = 'idTipoContacto';
    public $timestamps = false;

    protected $fillable = ['descripcion'];

    public function corredor_contacto(){
        return $this->belongsToMany('App\Corredor_Contacto', 'tipo', 'idTipoContacto');
    }
    public function titular_contacto(){
        return $this->belongsToMany('App\Titular_Contacto', 'tipo', 'idTipoContacto');
    }
    public function destino_contacto(){
        return $this->belongsToMany('App\Destino_Contacto', 'tipo', 'idTipoContacto');
    }
    public function entregador_contacto(){
        return $this->belongsToMany('App\Entregador_Contacto', 'tipo', 'idTipoContacto');
    }
    public function remitente_contacto(){
        return $this->belongsToMany('App\Remitente_Contacto', 'tipo', 'idTipoContacto');
    }
    public function intermediario_contacto(){
        return $this->belongsToMany('App\Intermediario_Contacto', 'tipo', 'idTipoContacto');
    }
}
