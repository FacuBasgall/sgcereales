<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Carga;
use App\Aviso;
use App\Corredor;
use App\Producto;
use App\Titular;
use App\Intermediario;
use App\Remitente_Comercial;
use App\User;
use App\Aviso_Entregador;
use App\Aviso_Producto;
use DB;

class CargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titulares = Titular::where('borrado', false)->get();
        $intermediarios = Intermediario::where('borrado', false)->get();
        $remitentes = Remitente_Comercial::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $entregadores = User::where('tipoUser', 'E')->get(); //Solo Usuarios Entregadores
        $productos = Producto::where('borrado', false)->get();

        return view('carga.create', compact(['titulares', 'intermediarios', 'remitentes', 'corredores', 'entregadores', 'productos']));    
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* $request->validate([
            
        ]); */
        $aviso = new Aviso;
        $aviso->idCorredor = $request->corredor;
        $aviso->idProducto = $request->producto;
        $aviso->idEntregador = 1;
        $aviso->estado = false;
        $aviso->save();

        $nuevo = new Carga;
        $nuevo->idAviso = $aviso->idAviso;
        $nuevo->idTitular = $request->titular;
        $nuevo->idIntermediario = $request->intermediario;
        $nuevo->idRemitenteComercial = $request->remitente;
        $nuevo->matriculaCamion = $request->matriculaCamion;
        $nuevo->nroCartaPorte = $request->cartaPorte;
        $nuevo->localidadProcedencia = $request->localidad;
        $nuevo->provinciaProcedencia = $request->provincia;
        $nuevo->fecha = $request->fecha;
        $nuevo->kilos = $request->kilos;
        $nuevo->save(); 

        $aviso_producto = new Aviso_Producto;
        $aviso_producto->idAviso = $aviso->idAviso;
        $aviso_producto->idProducto = $request->producto;
        $aviso_producto->cosecha = $request->cosecha;
        $aviso_producto->tipo = $request->tipo;
        $aviso_producto->save();

        $aviso_entregador = new Aviso_Entregador;
        $aviso_entregador->idAviso = $aviso->idAviso;
        $aviso_entregador->idEntregador = 1;
        $aviso_entregador->fecha = date("Y-m-d");
        $aviso_entregador->save();

        if(isset($request->check)){
            return redirect()->action('DescargaController@create', $nuevo->idCarga);
        }else{
            return redirect()->action('AvisoController@index');
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idCarga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idCarga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idCarga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idCarga)
    {
        //
    }
}
