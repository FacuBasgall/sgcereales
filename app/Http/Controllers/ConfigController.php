<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SweetAlert;

class ConfigController extends Controller
{
    protected $last_backup = NULL; //fecha y hora del ultimo bk realizado

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('config.index');
    }

    public function show_backup()
    {
        return view('config.backup');
    }

    public function run_backup()
    {
        $cmd = shell_exec("cd .. & php artisan backup:clean");
        $cmd = shell_exec("cd .. & php artisan backup:run --only-db");
        if(stristr($cmd, "Backup completed") === false){
            alert()->error("No se ha completado el proceso de backup", 'Ha ocurrido un error')->persistent('Cerrar');
            return back();
        }else{
            alert()->success("El proceso de backup se realizó correctamente", 'Backup completo')->persistent('Cerrar');
            return back();
        }
    }

    public function show_email()
    {
        //falta cargar los datos
        return view('config.email');
    }

    public function store_email(Request $request)
    {
        //guardar opciones predeterminadas de los corrreos
    }

    //duda: la configuracion del mail aca o en el UsuarioController ¡VER!
    //crear usuario, editar usuario actual
}
