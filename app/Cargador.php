<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargador extends Model
{
    protected $table = 'cargador';
    protected $primaryKey = 'cuit';
    public $timestamps = false;
}
