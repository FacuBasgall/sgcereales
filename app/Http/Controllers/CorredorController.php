<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\corredor;
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
        $arrayCorredor = DB::table('corredor')->get();
        return view('corredor.index', array('arraycorredor'=>$arrayCorredor));
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
        $nuevo = new Corredor;
        $nuevo = $request->all();
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
        return view('corredor.show', array('corredor'=>$corredor));
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
        $nuevo = $request->all();
        $nuevo->save();
        return view('corredor.edit', array('cuit'=>$cuit));
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
        $corredor->delete();
    }
}
