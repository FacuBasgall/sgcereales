<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Carga;
use App\Aviso;
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
    public function create(int $idAviso)
    {
        $aviso = Aviso::where('idAviso', $idAviso)->first();
        return view('carga.create', array('aviso'=>$aviso));
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

        ]); */

        $carga = new Carga;
        $carga->idAviso = $request->idAviso;
        $carga->matriculaCamion = $request->matricula;
        $carga->nroCartaPorte = $request->cartaPorte;
        $carga->fecha = $request->fecha;
        $carga->kilos = $request->kilos;
        $carga->borrado = false;
        $carga->save();

        if(isset($request->check)){
            return redirect()->action('DescargaController@create', $carga->idCarga);
        }else{
            return redirect()->action('AvisoController@index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idCarga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idCarga)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idCarga)
    {
        //
    }
}
