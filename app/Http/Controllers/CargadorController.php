<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargador;
use App\Cargador_Contacto;
use App\Condicion_IVA;
use App\Tipo_Contacto;
use DB;

class CargadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayCargador = DB::table('cargador')->where('borrado', false)->orderBy('nombre')->get();
        return view('cargador.index', array('arrayCargador'=>$arrayCargador));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $iva = Condicion_IVA::all();
        return view('cargador.create', array('iva'=>$iva));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existe = Cargador::where('cuit', $request->cuit)->exists();
        if($existe){
            $nuevo = Cargador::where('cuit', $request->cuit)->first();
        }
        else{
            $nuevo = new Cargador;
            $nuevo->cuit = $request->cuit;
        }
        $nuevo->nombre = $request->nombre;
        $nuevo->dgr = $request->dgr;
        $nuevo->cp = $request->cp;
        $nuevo->condIva = $request->iva;
        $nuevo->domicilio = $request->domicilio;
        $nuevo->localidad = $request->localidad;
        $nuevo->provincia = $request->provincia;
        $nuevo->pais = $request->pais;
        $nuevo->borrado = false;
        $nuevo->save();
        alert()->success("El cargador $nuevo->nombre fue creado con exito", 'Creado con exito');
        return redirect('/cargador');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cuit)
    {
        $cargador = Cargador::findOrFail($cuit);
        $contacto = Cargador_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        $iva = Condicion_IVA::all();
        return view('cargador.show',  compact(['cargador', 'contacto', 'tipoContacto', 'iva']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cuit)
    {
        $cargador = Cargador::findOrFail($cuit);
        $contacto = Cargador_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        $iva = Condicion_IVA::all();
        return view('cargador.edit', compact(['cargador', 'contacto', 'tipoContacto', 'iva']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cuit)
    {
        $nuevo = Cargador::findOrFail($cuit);
        $nuevo->nombre = $request->input('nombre');
        $nuevo->dgr = $request->input('dgr');
        $nuevo->cp = $request->input('cp');
        $nuevo->condIva = $request->input('iva');
        $nuevo->domicilio = $request->input('domicilio');
        $nuevo->localidad = $request->input('localidad');
        $nuevo->provincia = $request->input('provincia');
        $nuevo->pais = $request->input('pais');
        $nuevo->save();
        alert()->success("El cargador $nuevo->nombre fue editado con exito", 'Editado con exito');
        return redirect('/cargador');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cuit)
    {
        $cargador = Cargador::findOrFail($cuit);
        $cargador->borrado = true;
        $cargador->save();
        alert()->success("El corredor fue eliminado con exito", 'Eliminado con exito');
        return redirect('/cargador');
    }
}
