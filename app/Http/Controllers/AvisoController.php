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
        $var; $avisoProducto; $i = 0;
        $avisos = DB::table('aviso')->get();
        foreach($avisos as $aviso){
            $var['nroAviso'][$i] = $aviso->idAviso;
            $var['producto'][$i] = DB::table('aviso')
                ->join('producto', 'producto.id', '=', 'aviso.idProducto')
                ->select('producto.nombre')
                ->where('aviso.idAviso', $aviso->idAviso)
                ->get();
            $avisoProducto[][$i] = DB::table('aviso')
                ->join('aviso_producto', 'aviso_producto.idAviso', '=', 'aviso.idAviso')
                ->select('aviso_producto.*')
                ->whereColumn([
                    ['aviso_producto.idProducto', '=', $aviso->idProducto],
                    ['aviso_producto.idAviso', '=', $aviso->idAviso]
                ])->get();
            $var['corredor'][$i] = DB::table('aviso')
                ->join('corredor', 'corredor.cuit', '=', 'aviso.idCorredor')
                ->select('corredor.nombre')
                ->where('aviso.idAviso', $aviso->idAviso)
                ->get();
            //$var['entregador'][$i]
            //Copiar de $avisoProducto a $var
            $i ++;
        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('aviso.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                //FALTAN GUARDAR LOS DATOS
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
