<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Aviso;
use App\Descarga;
use App\Carga;
use App\Corredor;
use App\Producto;
use App\Destino;
use App\Titular;
use App\Titular_Contacto;
use App\Remitente_Contacto;
use App\Corredor_Contacto;
use App\Intermediario;
use App\Remitente_Comercial;
use App\User;
use App\Aviso_Producto;
use App\Aviso_Entregador;
use App\Entregador_Contacto;
use App\Entregador_Domicilio;
use App\Localidad;
use App\Provincia;

use Datatables;
use DB;
use SweetAlert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $entregadorAutenticado = auth()->user()->idUser;
        $avisos = Aviso::where('borrado', false)->where('estado', 0)->get(); //false, pendiente
        $cargas = Carga::where('borrado', false)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destinatarios = Destino::where('borrado', false)->get();
        $titulares = Titular::where('borrado', false)->get();
        $intermediarios = Intermediario::where('borrado', false)->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $productos = Producto::where('borrado', false)->get();
        $avisos_productos = Aviso_Producto::all();
        $avisos_entregadores = Aviso_Entregador::where('idEntregador', $entregadorAutenticado)->get();
        $localidades = Localidad::all();
        $provincias = Provincia::all();

        return view('home', compact(['avisos', 'cargas', 'descargas', 'destinatarios', 'titulares',
            'intermediarios', 'remitentes', 'corredores', 'productos', 'avisos_productos',
            'avisos_entregadores', 'localidades', 'provincias']));
    }

    public function verificacion()
    {
        /**Si el usuario es entregador devuelve la vista normal del sistema,
         * en cambio si es admin solo las funciones de este usuario
         */
        if(auth()->user()->tipoUser == 'E'){
            return redirect()->action('HomeController@index');
        }else{
            return redirect()->action('AdminController@index');
        }
    }
}
