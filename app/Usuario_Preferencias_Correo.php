<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario_Preferencias_Correo extends Model
{
    protected $table = 'usuario_preferencias_correo';
    protected $primaryKey = 'idUser';
    public $timestamps = false;

    protected $fillable = ['email', 'asunto', 'cuerpo'];

    public function usuario(){
        return $this->belongsTo('App\User', 'idUser', 'idUser');
    }
}
