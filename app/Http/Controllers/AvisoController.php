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
use Datatables;
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
        $avisos = Aviso::where('borrado', false)->orderBy('idAviso', 'desc')->get();
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $carga = Carga::where('borrado', false)->where('idAviso', $idAviso)->first();
        $descargas = Descarga::where('borrado', false)->where('idCarga', $carga->idCarga)->get();
        $destinos = Destino::where('borrado', false)->get();
        $cargador = Cargador::where('cuit', $carga->idCargador)->first();
        $corredor = Corredor::where('cuit', $aviso->idCorredor)->first();
        $entregador = User::where('idUser', $aviso->idEntregador)->first();
        $producto = Producto::where('idProducto', $aviso->idProducto)->first();
        $aviso_producto = Aviso_Producto::where('idAviso', $idAviso);
        $aviso_entregador = Aviso_Entregador::where('idAviso', $idAviso);

        return view('aviso.show', compact(['aviso', 'carga', 'descargas', 'destinos', 'cargador', 'corredor', 'entregador', 'producto', 'aviso_producto', 'aviso_entregador']));    
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
        $carga = Carga::where('borrado', false)->where('idAviso', $idAviso)->first();
        $descargas = Descarga::where('borrado', false)->where('idCarga', $carga->idCarga)->get();
        $destinos = Destino::where('borrado', false)->get();
        $cargador = Cargador::where('cuit', $carga->idCargador)->first();
        $corredor = Corredor::where('cuit', $aviso->idCorredor)->first();
        $entregador = User::where('idUser', $aviso->idEntregador)->first();
        $producto = Producto::where('idProducto', $aviso->idProducto)->first();
        $aviso_producto = Aviso_Producto::where('idAviso', $idAviso);
        $aviso_entregador = Aviso_Entregador::where('idAviso', $idAviso);
        
        return view('aviso.edit', compact(['avisos', 'carga', 'descargas', 'destinos', 'cargador', 'corredor', 'entregador', 'producto', 'aviso_producto', 'aviso_entregador']));    
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
        $carga = Carga::where('idAviso', $idAviso)->first();
        $descargas = Descarga::where('idCarga', $carga->idCarga)->get();
        foreach($descargas as $descarga){
            $descarga->delete();
        }
        $aviso_entregador = Aviso_Entregador::where('idAviso', $idAviso)->first();
        $aviso_producto = Aviso_Producto::where('idAviso', $idAviso)->first();
        $aviso_entregador->delete();
        $aviso_producto->delete();
        $carga->delete();
        $aviso->delete();
        alert()->success("El aviso fue eliminado con exito", 'Eliminado con exito');
        return redirect('/aviso');
    }
}
