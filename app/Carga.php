<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    protected $table = 'carga';
    protected $primaryKey = 'idCarga';
    public $timestamps = false;

    protected $fillable = ['idAviso', 'matriculaCamion', 'ctg', 'nroCartaPorte', 'fecha', 'kilos', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function aviso(){
        return $this->belongsTo('App\Aviso', 'idAviso', 'idCarga');
    }

    public function descargas(){
        return $this->hasOne('App\Descarga', 'idCarga', 'idCarga');
    }
}
