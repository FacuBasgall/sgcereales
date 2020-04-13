<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merma extends Model
{
    protected $table = 'merma';
    protected $primaryKey = 'idMerma';
    public $timestamps = false;

    protected $fillable = ['idProducto', 'humedad', 'merma'];

    public function producto(){
        return $this->belongsTo('App\Producto', 'idProducto', 'idMerma');
    }
    
}
