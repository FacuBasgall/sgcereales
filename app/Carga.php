<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    protected $table = 'carga';
    protected $primaryKey = 'idCarga';
    public $timestamps = false;

    protected $fillable = ['idAviso', 'idCargador', 'matriculaCamion', 'nroCartaPorte', 'fecha', 'kilos'];

    public function aviso(){
        return $this->belongsTo('App\Aviso', 'idAviso', 'idCarga');
    }
    public function cargador(){
        return $this->belongsTo('App\Cargador', 'idCargador', 'idCarga');
    }
    public function descarga(){
        return $this->hasMany('App\Descarga', 'idDescarga', 'idCarga');
    }
}
