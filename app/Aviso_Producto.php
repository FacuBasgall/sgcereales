<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aviso_Producto extends Model
{
    protected $table = 'aviso_producto';
    protected $primaryKey = 'idAviso';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['idProducto', 'cosecha', 'tipo'];

    public function aviso(){
        return $this->belongsTo('App\Aviso', 'idAviso', 'idAviso');
    }
    public function producto(){
        return $this->belongsTo('App\Producto', 'idProducto', 'idAviso');
    }
}
