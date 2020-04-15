<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    protected $table = 'carga';
    protected $primaryKey = 'idCarga';
    public $timestamps = false;

    protected $fillable = ['idAviso', 'idTitular', 'idIntermediario', 'idRemitenteComercial', 'matriculaCamion', 'nroCartaPorte', 'localidadProcedencia', 'provinciaProcedencia', 'fecha', 'kilos', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function aviso(){
        return $this->belongsTo('App\Aviso', 'idAviso', 'idCarga');
    }
    public function titular(){
        return $this->belongsTo('App\Titular', 'idTitular', 'idCarga');
    }
    public function intermediario(){
        return $this->belongsTo('App\Intermediario', 'idIntermediario', 'idCarga');
    }
    public function remitente(){
        return $this->belongsTo('App\Remitente_Comercial', 'idRemitente', 'idCarga');
    }
    public function descargas(){
        return $this->hasMany('App\Descarga', 'idCarga', 'idCarga');
    }
}
