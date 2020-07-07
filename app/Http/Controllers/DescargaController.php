<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Descarga;
use App\Aviso;
use App\Carga;
use App\Merma;
use App\Producto;
use DB;

class DescargaController extends Controller
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
    public function create(int $idCarga)
    {
        $carga = Carga::where('idCarga', $idCarga)->first();
        return view('descarga.create', array('carga'=>$carga));
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
       $descarga = new Descarga;
       $descarga->idCarga = $request->carga;
       $descarga->fecha = $request->fecha;
       $descarga->bruto = $request->bruto;
       $descarga->tara = $request->tara;
       $descarga->humedad = $request->humedad;
       $descarga->ph = $request->ph;
       $descarga->proteina = $request->proteina;
       $descarga->calidad = $request->calidad;
       $descarga->borrado = false;

        $carga = Carga::where('idCarga', $request->carga)->first();
        $aviso = Aviso::where('idAviso', $carga->idAviso)->first();
        $producto = Producto::where('idProducto', $aviso->idProducto)->first();
        $merma = Merma::where('idProducto', $producto->idProducto)->where('humedad', $descarga->humedad)->exists();
        if ($merma){
            $mermaManipuleo = $producto->mermaManipuleo;
            $mermaSecado = $merma->merma;
            $descarga->merma = $mermaManipuleo + $mermaSecado;
        }
        $descarga->save();

       /**FORMULAS
        *   NETO KG = BRUTO - TARA
            MERMA % = MERMA HUMEDAD + MERMA MANIPULEO
            MERMA KG = NETO KG x (MERMA % / 100)
            NETO FINAL = NETO KG - MERMA KG
            DIFERENCIA = NETO FINAL - KG CARGA
        */

        return redirect()->action('AvisoController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idDescarga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idDescarga)
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
    public function update(Request $request, $idDescarga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idDescarga)
    {
        //
    }
}
