<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filtro extends Model
{
    protected $table = 'filtro-reporte-temp';
    protected $primaryKey = 'idFiltro';
    public $timestamps = false;
    protected $fillable = ['fechaDesde', 'fechaHasta', 'idTitular', 'idRemitente', 'idCorredor', 'idDestinatario', 'idProducto', 'entregador'];

    public function reporte(){
        return $this->hasMany('App\Aviso', 'idFiltro', 'idFiltro');
    }

    public function corredor(){
        return $this->hasOne('App\Corredor', 'idCorredor', 'idFiltro');
    }

    public function titular(){
        return $this->hasOne('App\Titular', 'idTitular', 'idFiltro');
    }

    public function remitente(){
        return $this->hasOne('App\Remitente_Comercial', 'idRemitente', 'idFiltro');
    }

    public function destinatario(){
        return $this->hasOne('App\Destino', 'idDestinatario', 'idFiltro');
    }

    public function producto(){
        return $this->hasOne('App\Producto', 'idProducto', 'idFiltro');
    }
}
