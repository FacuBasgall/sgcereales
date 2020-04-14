<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Remitente_Comercial;
use App\Remitente_Contacto;
use App\Tipo_Contacto;
use DB;

class RemitenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayRemitente = DB::table('remitente')->where('borrado', false)->orderBy('nombre')->get();
        return view('remitente.index', array('arrayRemitente'=>$arrayRemitente));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoContacto = Tipo_Contacto::all();
        return view('remitente.create', array('tipoContacto'=>$tipoContacto));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existe = Remitente_Comercial::where('cuit', $request->cuit)->exists();
        if($existe){
            $nuevo = Remitente_Comercial::where('cuit', $request->cuit)->first();
        }
        else{
            $nuevo = new Remitente_Comercial;
            $nuevo->cuit = $request->cuit;
        }
        $nuevo->nombre = $request->nombre;
        $nuevo->borrado = false;
        $nuevo->save();
        alert()->success("El remitente $nuevo->nombre fue creado con exito", 'Creado con exito');
        return redirect('/remitente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function show($cuit)
    {
        $remitente = Remitente_Comercial::findOrFail($cuit);
        $contacto = Remitente_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        return view('remitente.show', compact(['remitente', 'contacto', 'tipoContacto']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function edit($cuit)
    {
        $remitente = Remitente_Comercial::findOrFail($cuit);
        return view('remitente.edit', array('remitente'=>$remitente));
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
        $nuevo = Remitente_Comercial::findOrFail($cuit);
        $nuevo->nombre = $request->input('nombre');
        $nuevo->save();
        alert()->success("El remitente $nuevo->nombre fue editado con exito", 'Editado con exito');
        return redirect('/remitente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function destroy($cuit)
    {
        $remitente = Remitente_Comercial::findOrFail($cuit);
        $remitente->borrado = true;
        $remitente->save();
        alert()->success("El remitente fue eliminado con exito", 'Eliminado con exito');
        return redirect('/remitente');
    }
}
