<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aviso;
use App\Carga;
use App\Corredor;
use App\Producto;
use App\Descarga;
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
        $arrayAviso = DB::table('aviso')->get();
        $arrayProducto = DB::table('producto')->get();
        $arrayCorredor = DB::table('corredor')->get();
        $arrayCarga = DB::table('carga')->get();
        

        return view('aviso.index', array('arrayAviso'=>$arrayAviso), array('arrayProducto'=>$arrayProducto),
        array('arrayCorredor'=>$arrayCorredor), array('arrayCarga'=>$arrayCarga),);
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
        return view('aviso.edit', array('idAvisoAviso'=>$idAviso));
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
