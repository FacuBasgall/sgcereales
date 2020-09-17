<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincia';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nombre', 'abreviatura'];

    public function localidad(){
        return $this->hasMany('App\Localidad', 'idProducto', 'id');
    }
}
