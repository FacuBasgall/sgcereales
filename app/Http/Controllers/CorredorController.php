<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Corredor;
use App\Corredor_Contacto;
use App\Tipo_Contacto;
use DB;

class CorredorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayCorredor = DB::table('corredor')->where('borrado', false)->get();
        return view('corredor.index', array('arrayCorredor'=>$arrayCorredor));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('corredor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existe = Corredor::where('cuit', $request->cuit)->exists();
        if($existe){
            $nuevo = Corredor::where('cuit', $request->cuit)->first();
        }
        else{
            $nuevo = new Corredor;
            $nuevo->cuit = $request->cuit;
        }
        $nuevo->nombre = $request->nombre;
        $nuevo->borrado = false;
        $nuevo->save();
        return redirect('/corredor');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function show($cuit)
    {
        $corredor = Corredor::findOrFail($cuit);
        $contacto = Corredor_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        return view('corredor.show', compact(['corredor', 'contacto', 'tipoContacto']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function edit($cuit)
    {
        $corredor = Corredor::findOrFail($cuit);
        return view('corredor.edit', array('corredor'=>$corredor));
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
        $nuevo = Corredor::findOrFail($cuit);
        $nuevo->nombre = $request->input('nombre');
        $nuevo->save();
        return redirect('/corredor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function destroy($cuit)
    {
        $corredor = Corredor::findOrFail($cuit);
        $corredor->borrado = true;
        $corredor->save();
        return redirect('/corredor');
    }
}
