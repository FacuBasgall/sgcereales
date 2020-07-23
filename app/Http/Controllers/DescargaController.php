<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Descarga;
use App\Merma;
use App\Aviso;
use App\Carga;
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
    public function create($idCarga)
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
        $carga = Carga::where('idCarga', $request->carga)->first();
        $hoy = date("Y-m-d");

        if($request->fecha >= $carga->fecha && $request->fecha <= $hoy){
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

            $aviso = Aviso::where('idAviso', $carga->idAviso)->first();
            $producto = Producto::where('idProducto', $aviso->idProducto)->first();
            $existe = Merma::where('idProducto', $producto->idProducto)->where('humedad', $descarga->humedad)->exists();
            if ($existe){
                $merma = Merma::where('idProducto', $producto->idProducto)->where('humedad', $descarga->humedad)->first();
                $mermaManipuleo = $producto->mermaManipuleo;
                $mermaSecado = $merma->merma;
                $descarga->merma = $mermaManipuleo + $mermaSecado;
            }else{
                $descarga->merma = NULL;
            }
            $descarga->save();

            alert()->success("La descarga fue creada con exito", 'Descarga guardada');
            return redirect()->action('AvisoController@show', $carga->idAviso);
        }elseif($request->fecha > $hoy){
            alert()->error("La fecha no puede ser mayor al dia de hoy", 'Ha ocurrido un error');
            return back()->withInput();
        }else{
            alert()->error("La fecha no puede ser menor a la fecha de carga", 'Ha ocurrido un error');
            return back()->withInput();
        }

       /**FORMULAS
        *   NETO KG = BRUTO - TARA
            MERMA % = MERMA HUMEDAD + MERMA MANIPULEO
            MERMA KG = NETO KG x (MERMA % / 100)
            NETO FINAL = NETO KG - MERMA KG
            DIFERENCIA = NETO FINAL - KG CARGA
        */

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
        $carga = Carga::where('idCarga', $request->carga)->first();
        $hoy = date("Y-m-d");

        if($request->fecha >= $carga->fecha && $request->fecha <= $hoy){
            $descarga = Descarga::findOrfail($idDescarga);
            $descarga->fecha = $request->fecha;
            $descarga->bruto = $request->bruto;
            $descarga->tara = $request->tara;
            $descarga->humedad = $request->humedad;
            $descarga->ph = $request->ph;
            $descarga->proteina = $request->proteina;
            $descarga->calidad = $request->calidad;

            $aviso = Aviso::where('idAviso', $carga->idAviso)->first();
            $producto = Producto::where('idProducto', $aviso->idProducto)->first();
            $merma = Merma::where('idProducto', $producto->idProducto)->where('humedad', $request->humedad)->exists();
            if ($merma){
                $mermaManipuleo = $producto->mermaManipuleo;
                $mermaSecado = $merma->merma;
                $descarga->merma = $mermaManipuleo + $mermaSecado;
            }else{
                $descarga->merma = NULL;
            }
            $descarga->save();
            alert()->success("La descarga fue editada con exito", 'Descarga guardada');
            return back();
        }elseif($request->fecha > $hoy){
            alert()->error("La fecha no puede ser mayor al dia de hoy", 'Ha ocurrido un error');
            return back()->withInput();
        }else{
            alert()->error("La fecha no puede ser menor a la fecha de carga", 'Ha ocurrido un error');
            return back()->withInput();
        }
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
