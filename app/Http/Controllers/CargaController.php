<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Carga;
use App\Aviso;
use App\Descarga;
use DB;
use SweetAlert;

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
    public function create($idAviso)
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
        $hoy = date("Y-m-d");

        if($request->fecha <= $hoy){
            $carga = new Carga;
            $carga->idAviso = $request->idAviso;
            $carga->matriculaCamion = $request->matricula;
            $carga->nroCartaPorte = $request->cartaPorte;
            $carga->fecha = $request->fecha;
            $carga->kilos = $request->kilos;
            $carga->borrado = false;
            $carga->save();

            alert()->success("La carga fue creada con exito", 'Carga guardada');
            if(isset($request->check)){
                return redirect()->action('DescargaController@create', $carga->idCarga);
            }else{
                return redirect()->action('AvisoController@index');
            }
        }else{
            alert()->error("La fecha no puede ser mayor al dia de hoy", 'Ha ocurrido un error')->persistent('Cerrar');
            return back()->withInput();
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
    public function edit($idAviso)
    {
        $cargas = Carga::where('idAviso', $idAviso)->get();
        $descargas = Descarga::where('borrado', false)->get();
        return view('carga.edit', compact(['cargas', 'descargas']));
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
        $hoy = date("Y-m-d");

        if($request->fecha <= $hoy){
            $carga = Carga::findOrfail($idCarga);
            $carga->matriculaCamion = $request->matricula;
            $carga->nroCartaPorte = $request->cartaPorte;
            $carga->fecha = $request->fecha;
            $carga->kilos = $request->kilos;
            $carga->save();

            alert()->success("La carga fue editada con exito", 'Carga guardada');
            return back();
        }else{
            alert()->error("La fecha no puede ser mayor al dia de hoy", 'Ha ocurrido un error')->persistent('Cerrar');
            return back();
        }
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
