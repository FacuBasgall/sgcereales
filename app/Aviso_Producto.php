<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aviso_Producto extends Model
{
    protected $table = 'aviso_producto';
    public $timestamps = false;
    protected $fillable = ['idAviso', 'idProducto', 'cosecha', 'fecha', 'tipo'];

    public function aviso(){
        return $this->belongsTo('App\Aviso', 'idAviso', 'idAviso');
    }
    public function producto(){
        return $this->belongsTo('App\Producto', 'idProducto', 'idProducto');
    }
}