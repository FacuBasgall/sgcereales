<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    protected $table = 'carga';
    protected $primaryKey = 'idCarga';
    public $timestamps = false;
}
