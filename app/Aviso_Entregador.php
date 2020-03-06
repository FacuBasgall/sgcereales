<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aviso_Entregador extends Model
{
    protected $table = 'aviso_entregador';
    public $timestamps = false;
    protected $fillable = ['idAviso', 'idEntregador', 'fecha'];

    public function aviso(){
        return $this->belongsTo('App\Aviso', 'idAviso', 'idAviso');
    }
    public function aviso_entregador(){
        return $this->belongsTo('App\Aviso_Entregador', 'idUser', 'idEntregador');
    }
}
