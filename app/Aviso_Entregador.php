<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aviso_Entregador extends Model
{
    protected $table = 'aviso_entregador';
    protected $primaryKey = 'idAviso';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['idEntregador', 'fecha'];

    public function aviso(){
        return $this->belongsTo('App\Aviso', 'idAviso', 'idAviso');
    }
}
