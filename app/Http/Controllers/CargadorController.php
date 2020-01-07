<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargador;
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
        $arrayCargador = DB::table('cargador')->get();
        return view('cargador.index', array('arrayCargador'=>$arrayCargador));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cargador.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevo = new Cargador;
        $nuevo = $request->all();
        $nuevo->save();
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
        return view('cargador.show', array('cargador'=>$cargador));
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
        return view('cargador.edit', array('cargador'=>$cargador));
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
        $nuevo = $request->all();
        $nuevo->save();
        return view('cargador.edit', array('cuit'=>$cuit));
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
        $cargador->delete();
    }
}
