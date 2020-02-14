<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Descarga;
use DB;

class DescargaController extends Controller
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
        return view('descarga.create');
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
        return redirect('/descarga');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idDescarga)
    {
        $descarga = Descarga::findOrFail($idDescarga);
        return view('descarga.show', array('descarga'=>$descarga));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idDescarga)
    {
        $descarga = Descarga::findOrFail($idDescarga);
        return view('descarga.edit', array('descarga'=>$descarga));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idDescarga)
    {
        $nuevo = Descarga::findOrFail($idDescarga);
        $nuevo = $request->all();
        $nuevo->save();
        return view('descarga.edit', array('idDescarga'=>$idDescarga));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idDescarga)
    {
        $descarga = Descarga::findOrFail($idDescarga);
        $descarga->delete();
    }
}
