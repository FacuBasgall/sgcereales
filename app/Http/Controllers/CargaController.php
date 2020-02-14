<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carga;
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
        return view('carga.create');

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
        return redirect('/carga');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idCarga)
    {
        $carga = Carga::findOrFail($idCarga);
        return view('carga.show', array('carga'=>$carga));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idCarga)
    {
        $carga = Carga::findOrFail($idCarga);
        return view('carga.edit', array('carga'=>$carga));
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
        $nuevo = Carga::findOrFail($idCarga);
        $nuevo = $request->all();
        $nuevo->save();
        return view('carga.edit', array('idCarga'=>$idCarga));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idCarga)
    {
        $carga = Carga::findOrFail($idCarga);
        $carga->delete();
    }
}
