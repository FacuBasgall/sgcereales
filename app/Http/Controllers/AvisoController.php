<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Aviso;
use App\Descarga;
use App\Carga;
use App\Corredor;
use App\Producto;
use App\Destino;
use App\Cargador;
use App\User;
use App\Aviso_Producto;


use DB;

class AvisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $avisos = Aviso::where('borrado', false)->get();
        $cargas = Carga::where('borrado', false)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destinos = Destino::where('borrado', false)->get();
        $cargadores = Cargador::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $entregadores = User::where('tipoUser', 'E')->get(); //Solo Usuarios Entregadores
        $productos = Producto::where('borrado', false)->get();

        /* No se si es necesario
        $aviso_producto = Aviso_Producto::all();
        $aviso_entregador = Aviso_Entregador::all();
        */
        return view('aviso.index', compact(['avisos', 'cargas', 'descargas', 'destinos', 'cargadores', 'corredores', 'entregadores', 'productos']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $avisos = Aviso::where('borrado', false)->get();
        $cargas = Carga::where('borrado', false)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destinos = Destino::where('borrado', false)->get();
        $cargadores = Cargador::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $entregadores = User::where('tipoUser', 'E')->get(); //Solo Usuarios Entregadores
        $productos = Producto::where('borrado', false)->get();

        return view('aviso.create', compact(['avisos', 'cargas', 'descargas', 'destinos', 'cargadores', 'corredores', 'entregadores', 'productos']));    
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

        ]);
        return redirect('/aviso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idAviso
     * @return \Illuminate\Http\Response
     */
    public function show($idAviso)
    {
        $aviso = Aviso::findOrFail($idAviso);
        return view('aviso.show', array('aviso'=>$aviso));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $idAviso
     * @return \Illuminate\Http\Response
     */
    public function edit($idAviso)
    {
        $aviso = Aviso::findOrFail($idAviso);
        return view('aviso.edit', array('aviso'=>$aviso));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idAviso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idAviso)
    {
        $nuevo = Aviso::findOrFail($idAviso);
        $nuevo = $request->all();
        $nuevo->save();
        return view('aviso.edit', array('idAviso'=>$idAviso));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $idAviso
     * @return \Illuminate\Http\Response
     */
    public function destroy($idAviso)
    {
        $aviso = Aviso::findOrFail($idAviso);
        $aviso->delete();
    }
}
