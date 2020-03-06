<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entregador_Contacto extends Model
{
    protected $table = 'entregador_contacto';
    public $timestamps = false;
    protected $fillable = ['idUser', 'contacto', 'tipo'];

    public function usuario(){
        return $this->belongsTo('App\Usuario', 'idUser');
    }
    public function tipo_contacto(){
        return $this->belongsTo('App\Tipo_Contacto', 'tipo');
    }
}
