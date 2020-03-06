<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entregador_Domicilio extends Model
{
    protected $table = 'entregador_domicilio';
    public $timestamps = false;
    protected $fillable = ['idUser', 'cp', 'domicilio', 'localidad', 'provincia', 'pais'];

    public function usuario(){
        return $this->belongsTo('App\Usuario', 'idUser', 'idUser');
    }
}
