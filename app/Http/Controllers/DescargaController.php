<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Descarga;
use App\Aviso;
use App\Carga;
use App\Corredor;
use App\Producto;
use App\Destino;
use App\Titular;
use App\Aviso_Producto;
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
        $destinos = Destino::where('borrado', false)->get();
        $carga = Carga::where('idCarga', $idCarga)->first();
        $descargas = Descarga::where('idCarga', $idCarga)->get();
        return view('descarga.create', compact(['carga', 'destinos', 'descargas']));    
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
       $nuevo = new Descarga;
       $nuevo->idCarga = $request->carga;
       $nuevo->idDestinatario = $request->destino;
       $nuevo->fecha = $request->fecha;
       $nuevo->localidad = $request->localidad;
       $nuevo->provicia = $request->provincia;
       $nuevo->bruto = $request->bruto;
       $nuevo->tara = $request->tara;
       $nuevo->humedad = $request->humedad;
       $nuevo->merma = $request->merma;
       $nuevo->ph = $request->ph;
       $nuevo->proteina = $request->proteina;
       $nuevo->calidad = $request->calidad;
       $nuevo->borrado = false;

       $carga = Carga::where('idCarga', $nuevo->idCarga)->first();

       if($carga->kilos == $nuevo->bruto){ //NO ESTOY SEGURO SI ES BRUTO - VER FORMULA
            /**Si se descargaron todos los kilos */
            if(isset($request->check)){
                //ERROR
                return print_r("No puede estar seleccionado el checkbox porque no hay mas kilos para descargar");
            }else{
                $nuevo->save();
                $aviso = Aviso::where('idAviso', $carga->idAviso)->update('estado', true);
                return redirect()->action('AvisoController@index');
            }
       }elseif ($carga->kilos > $nuevo->bruto){
            $nuevo->save();
           /**Si NO se descargaron todos los kilos */
           if(isset($request->check)){
                return redirect()->action('DescargaController@create', $carga->idCarga);
           }else{
                return redirect()->action('AvisoController@index');
           }
       }else{
           //ERROR
           return print_r("Los kilos descargados no pueden ser mayores a los kilos cargados");
       }
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
