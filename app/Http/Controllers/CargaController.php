<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Carga;
use App\Aviso;
use App\Descarga;
use App\Producto;
use App\Merma;

use DB;
use SweetAlert;

class CargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

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
            $existe = Carga::where('nroCartaPorte', $request->cartaPorte)->exists();
            if(!$existe){
                $carga = new Carga;
                $carga->idAviso = $request->idAviso;
                $carga->matriculaCamion = $request->matricula;
                $carga->nroCartaPorte = $request->cartaPorte;
                $carga->fecha = $request->fecha;
                $carga->kilos = $request->kilos;
                $carga->borrado = false;
                $carga->save();

                alert()->success("La carga fue creada con éxito", 'Carga guardada');
                if(isset($request->check)){
                    return redirect()->action('DescargaController@create', $carga->idCarga);
                }else{
                    $aviso = Aviso::where('idAviso', $carga->idAviso)->first();
                    if($aviso->estado){
                        return redirect()->action('AvisoController@change_status', $carga->idAviso);
                    }else{
                        return redirect()->action('AvisoController@show', $carga->idAviso);
                    }
                }
            }else{
                alert()->error("El Nro de carta porte ya existe", 'Ha ocurrido un error')->persistent('Cerrar');
                return back()->withInput();
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
    public function edit($idCarga)
    {
        $carga = Carga::where('idCarga', $idCarga)->first();
        $descarga = Descarga::where('idCarga', $idCarga)->first();
        $calidadDB = DB::table('descarga')
                        ->distinct()
                        ->select('descarga.calidad')
                        ->get();
        $calidad = array();
        foreach($calidadDB as $c){
            $calidad[] = $c;
        }
        return view('carga.edit', compact(['carga', 'descarga', 'calidad']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $hoy = date("Y-m-d");

        if($request->fecha <= $hoy){
            $carga = Carga::findOrfail($request->idCarga);
            $carga->matriculaCamion = $request->matricula;
            $carga->nroCartaPorte = $request->cartaPorte;
            $carga->fecha = $request->fecha;
            $carga->kilos = $request->kilos;
            $carga->save();
            if(Descarga::where('idCarga', $carga->idCarga)->exists()){
                $descarga = Descarga::where('idCarga', $carga->idCarga)->first();
                if($request->fechaDescarga >= $carga->fecha && $request->fechaDescarga <= $hoy){
                    $descarga->fecha = $request->fechaDescarga;
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
                        $merma = Merma::where('idProducto', $producto->idProducto)->where('humedad', $descarga->humedad)->first();
                        $mermaManipuleo = $producto->mermaManipuleo;
                        $mermaSecado = $merma->merma;
                        $descarga->merma = $mermaManipuleo + $mermaSecado;
                    }else{
                        $descarga->merma = NULL;
                    }
                    $descarga->save();
                    alert()->success("La carga y descarga fueron editadas con éxito", 'Carga y descarga guardada');
                    return redirect()->action('AvisoController@show', $carga->idAviso);
                }elseif($request->fechaDescarga > $hoy){
                    alert()->error("La fecha de la descarga no puede ser mayor al dia de hoy", 'Ha ocurrido un error')->persistent('Cerrar');
                    return back()->withInput();
                }else{
                    alert()->error("La fecha de la descarga no puede ser menor a la fecha de carga", 'Ha ocurrido un error')->persistent('Cerrar');
                    return back()->withInput();
                }
            }else{
                alert()->success("La carga fue editada con éxito", 'Carga guardada');
                return redirect()->action('AvisoController@show', $carga->idAviso);
            }
        }else{
            alert()->error("La fecha de la carga no puede ser mayor al dia de hoy", 'Ha ocurrido un error')->persistent('Cerrar');
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
