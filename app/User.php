<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'idUser';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'tipoUser', 'cuit', 'descripcion',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function tipo_contacto(){
        return $this->belongsToMany('App\Tipo_Contacto', 'Entregador_Contacto', 'idUser', 'idTipoContacto');
    }
    public function entregador_domicilio(){
        return $this->hasMany('App\Entregador_Domicilio', 'idUser', 'idUser');
    }
}
