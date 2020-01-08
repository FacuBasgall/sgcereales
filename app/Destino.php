<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table = 'destinatario';
    protected $primaryKey = 'cuit';
    public $timestamps = false;
}
