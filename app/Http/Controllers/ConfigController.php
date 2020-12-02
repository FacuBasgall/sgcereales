<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SweetAlert;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function run_backup()
    {
        $cmd = shell_exec("cd .. & php artisan backup:clean");
        $cmd = shell_exec("cd .. & php artisan backup:run --only-db");
        if(stristr($cmd, "Backup completed") === false){
            alert()->error("No se ha completado el proceso de backup", 'Ha ocurrido un error')->persistent('Cerrar');
            return back();
        }else{
            alert()->success("Ya puede utilizar el sistema", 'Backup completo')->persistent('Cerrar');
            return back();
        }
    }
}
