<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descarga extends Model
{
    protected $table = 'descarga';
    protected $primaryKey = 'idDescarga';
    public $timestamps = false;

    protected $fillable = ['idCarga', 'fecha', 'bruto', 'tara', 'humedad', 'merma', 'ph', 'proteina', 'calidad', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function carga(){
        return $this->belongsTo('App\Carga', 'idDestinatario', 'idDescarga');
    }
}
