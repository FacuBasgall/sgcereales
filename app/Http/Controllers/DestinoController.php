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
        $arrayDestino = DB::table('destinatario')->where('borrado', false)->get();
        return view('destino.index', array('arrayDestino'=>$arrayDestino));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $iva = Condicion_IVA::all();
        return view('destino.create', array('iva'=>$iva));
        
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
        $nuevo->condIva = $request->input('iva');
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
        $contacto = Destino_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        $iva = Condicion_IVA::all();
        return view('destino.show', compact(['destino', 'contacto', 'tipoContacto', 'iva']));
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
        $contacto = Destino_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        $iva = Condicion_IVA::all();
        return view('destino.edit', compact(['destino', 'contacto', 'tipoContacto', 'iva']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $cuit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cuit)
    {
        $nuevo = Destino::findOrFail($cuit);
        $nuevo->nombre = $request->input('nombre');
        $nuevo->dgr = $request->input('dgr');
        $nuevo->cp = $request->input('cp');
        $nuevo->condIva = $request->input('iva');
        $nuevo->domicilio = $request->input('domicilio');
        $nuevo->localidad = $request->input('localidad');
        $nuevo->provincia = $request->input('provincia');
        $nuevo->pais = $request->input('pais');
        $nuevo->save();
        return redirect('/destino');
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
        $destino->borrado = true;
        $destino->save();
        return redirect('/destino');
    }
}
