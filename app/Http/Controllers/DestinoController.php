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
        $arrayDestino = DB::table('destinatario')->where('borrado', false)->orderBy('nombre')->get();
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
        $tipoContacto = Tipo_Contacto::all();
        return view('destino.create', compact(['iva', 'tipoContacto']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* $request->validate([
            'cuit' => 'required | max:20',
            'nombre' => 'required | max:200',
            'cp' => 'numeric | max:10',
            'iva' => 'required',
        ]);
         */
        $existe = Destino::where('cuit', $request->cuit)->exists();
        if($existe){
            $nuevo = Destino::where('cuit', $request->cuit)->first();
        }
        else{
            $nuevo = new Destino;
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
        alert()->success("El destinatario $nuevo->nombre fue creado con exito", 'Creado con exito');
        /* $destino_contacto = new Destino_Contacto;
        $destino_contacto->cuit = $request->cuit;
        $destino_contacto->contacto = $request
        $destino_contacto->tipo = $request */

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
        alert()->success("El destinatario $nuevo->nombre fue editado con exito", 'Editado con exito');
        //CONTACTOS
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
        alert()->success("El destinatario fue eliminado con exito", 'Eliminado con exito');
        return redirect('/destino');
    }
}
