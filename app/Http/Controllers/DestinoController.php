<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Destino;
use App\Destino_Contacto;
use App\Condicion_IVA;
use App\Tipo_Contacto;
use DB;

class DestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayDestino = DB::table('destinatario')->get();
        return view('destino.index', array('arrayDestino'=>$arrayDestino));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('destino.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevo = new Destino;
        $nuevo->cuit = $request->input('cuit');
        $nuevo->nombre = $request->input('nombre');
        $nuevo->dgr = $request->input('dgr');
        $nuevo->cp = $request->input('cp');
        $nuevo->domicilio = $request->input('domicilio');
        $nuevo->localidad = $request->input('localidad');
        $nuevo->provincia = $request->input('provincia');
        $nuevo->pais = $request->input('pais');
        $nuevo->save();
        return redirect('/destino');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function show($cuit)
    {
        $destino = Destino::findOrFail($cuit);
        return view('destino.show', array('destino'=>$destino));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function edit($cuit)
    {
        $destino = Destino::findOrFail($cuit);
        return view('destino.edit', array('destino'=>$destino));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cuit)
    {
        $nuevo = Destino::findOrFail($cuit);
        $nuevo->cuit = $request->input('cuit');
        $nuevo->nombre = $request->input('nombre');
        $nuevo->condIva = 1;
        $nuevo->dgr = $request->input('dgr');
        $nuevo->cp = $request->input('cp');
        $nuevo->domicilio = $request->input('domicilio');
        $nuevo->localidad = $request->input('localidad');
        $nuevo->provincia = $request->input('provincia');
        $nuevo->pais = $request->input('pais');
        $nuevo->save();
        return view('destino.edit', array('cuit'=>$cuit));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function destroy($cuit)
    {
        $destino = Destino::findOrFail($cuit);
        $destino->delete();
    }
}
