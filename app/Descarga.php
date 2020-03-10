<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descarga extends Model
{
    protected $table = 'descarga';
    protected $primaryKey = 'idDescarga';
    public $timestamps = false;

    protected $fillable = ['idCarga', 'idDestinatario', 'fecha', 'bruto', 'tara', 'humedad', 'merma', 'ph', 'proteina', 'calidad'];
    
    public function destino(){
        return $this->belongsTo('App\Destino', 'idDestinatario', 'idDestinatario');
    }
    public function Carga(){
        return $this->belongsTo('App\Carga', 'idCarga', 'idCarga');
    }
}
