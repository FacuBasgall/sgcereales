<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corredor extends Model
{
    protected $table = 'corredor';
    protected $primaryKey = 'cuit';
    public $timestamps = false;
}
