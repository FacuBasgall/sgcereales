<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidad';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['idProvincia', 'nombre'];

    public function provincia(){
        return $this->belongsTo('App\Provincia', 'id', 'idProducto');
    }
}
