<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'idUser';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'tipoUser', 'cuit', 'nombre', 'descripcion',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function entregador_contacto(){
        return $this->hasMany('App\entregador_Contacto', 'idUser', 'idUser');
    }
    public function entregador_domicilio(){
        return $this->hasMany('App\Entregador_Domicilio', 'idUser', 'idUser');
    }
    public function aviso_entregador(){
        return $this->hasMany('App\Aviso_Entregador', 'idEntregador', 'idUser');
    }
}
