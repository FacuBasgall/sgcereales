<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descarga extends Model
{
    protected $table = 'descarga';
    protected $primaryKey = 'idDescarga';
    public $timestamps = false;
}
