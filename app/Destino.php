<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table = 'destinatario';
    protected $primaryKey = 'cuit';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre', 'condIva', 'dgr', 'cp', 'domicilio', 'localidad', 'provincia', 'pais', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function destino_contacto(){
        return $this->hasMany('App\Destino_Contacto', 'cuit', 'cuit');
    }

    public function condicion_iva(){
        return $this->belongsTo('App\Condicion_IVA', 'condIva', 'cuit');
    }

    public function aviso(){
        return $this->hasMany('App\Aviso', 'idDestinatario', 'cuit');
    }

    public function filtro(){
        return $this->belongsTo('App\Filtro', 'idDestinatario', 'cuit');
    }
}
