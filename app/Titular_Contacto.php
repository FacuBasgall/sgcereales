<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Titular_Contacto extends Model
{
    protected $table = 'titular_contacto';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['cuit', 'contacto', 'tipo'];

    public function Titular(){
        return $this->belongsTo('App\Titular', 'cuit', 'cuit');
    }
    public function tipo_contacto(){
        return $this->belongsTo('App\Tipo_Contacto', 'idTipoContacto', 'tipo');
    }
}
