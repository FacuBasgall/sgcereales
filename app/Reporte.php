<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reporte-temp';
    protected $primaryKey = 'idReporte';
    public $timestamps = false;
    protected $fillable = ['idFiltro', 'idAviso'];

    public function aviso(){
        return $this->hasOne('App\Aviso', 'idAviso', 'idAviso');
    }

    public function filtro(){
        return $this->belongsTo('App\Filtro', 'idFiltro', 'idFiltro');
    }
}
