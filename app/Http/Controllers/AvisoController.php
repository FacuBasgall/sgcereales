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
use App\Aviso_Entregador;

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
        $avisos_productos = Aviso_Producto::all();
        $avisos_entregadores = Aviso_Entregador::all();

        return view('aviso.index', compact(['avisos', 'cargas', 'descargas', 'destinos', 'cargadores', 'corredores', 'entregadores', 'productos', 'avisos_productos', 'avisos_entregadores']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* $avisos = Aviso::where('borrado', false)->get();
        $cargas = Carga::where('borrado', false)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destinos = Destino::where('borrado', false)->get();
        $cargadores = Cargador::where('borrado', false)->get();
        $corredores = Corredor::where('borrado', false)->get();
        $entregadores = User::where('tipoUser', 'E')->get(); //Solo Usuarios Entregadores
        $productos = Producto::where('borrado', false)->get();
        $avisos_productos = Aviso_Producto::all();
        $avisos_entregadores = Aviso_Entregador::all();

        return view('aviso.create', compact(['avisos', 'cargas', 'descargas', 'destinos', 'cargadores', 'corredores', 'entregadores', 'productos', 'avisos_productos', 'avisos_entregadores']));    
     */
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //FALTA
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
        $carga = Carga::where('idAviso', $idAviso)->where('idAviso', $idAviso)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destinos = Destino::where('borrado', false)->get();
        $cargadores = Cargador::where('borrado', false)->get();
        $corredor = Corredor::where('borrado', false)->where('cuit', $aviso->idCorredor)->get();
        $entregador = User::where('tipoUser', 'E')->where('idUser', $aviso->idEntregador)->get();
        $producto = Producto::where('borrado', false)->where('idProducto', $aviso->idProducto)->get();
        $aviso_producto = Aviso_Producto::where('idAviso', $idAviso);
        $aviso_entregador = Aviso_Entregador::where('idAviso', $idAviso);

        return view('aviso.show', compact(['avisos', 'carga', 'descargas', 'destinos', 'cargadores', 'corredor', 'entregador', 'producto', 'aviso_producto', 'aviso_entregador']));    
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
        $carga = Carga::where('idAviso', $idAviso)->where('idAviso', $idAviso)->get();
        $descargas = Descarga::where('borrado', false)->get();
        $destinos = Destino::where('borrado', false)->get();
        $cargadores = Cargador::where('borrado', false)->get();
        $corredor = Corredor::where('borrado', false)->where('cuit', $aviso->idCorredor)->get();
        $entregador = User::where('tipoUser', 'E')->where('idUser', $aviso->idEntregador)->get();
        $producto = Producto::where('borrado', false)->where('idProducto', $aviso->idProducto)->get();
        $aviso_producto = Aviso_Producto::where('idAviso', $idAviso);
        $aviso_entregador = Aviso_Entregador::where('idAviso', $idAviso);
        
        return view('aviso.edit', compact(['avisos', 'carga', 'descargas', 'destinos', 'cargadores', 'corredor', 'entregador', 'producto', 'aviso_producto', 'aviso_entregador']));    
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
        //FALTA
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
        //FALTA
        /* $aviso = Aviso::findOrFail($idAviso);
        $aviso->delete(); */
    }
}
