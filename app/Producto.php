<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;

    protected $fillable = ['nombre', 'merma', 'borrado'];

    protected $attributes = [
        'borrado' => false,
    ];

    public function aviso_producto(){
        return $this->hasMany('App\Aviso_Producto', 'idProducto', 'idProducto');
    }

}
