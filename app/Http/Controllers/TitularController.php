<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Titular;
use App\Titular_Contacto;
use App\Condicion_IVA;
use App\Tipo_Contacto;
use DB;

class TitularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayTitular = DB::table('titular')->where('borrado', false)->orderBy('nombre')->get();
        return view('titular.index', array('arrayTitular'=>$arrayTitular));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('titular.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existe = Titular::where('cuit', $request->cuit)->exists();
        if($existe){
            $nuevo = Titular::where('cuit', $request->cuit)->first();
        }
        else{
            $nuevo = new Titular;
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
        alert()->success("El titular $nuevo->nombre fue creado con exito", 'Creado con exito');
        return redirect()->action('TitularController@contact', $request->cuit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cuit)
    {
        $titular = Titular::findOrFail($cuit);
        $contacto = Titular_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        $iva = Condicion_IVA::all();
        return view('titular.show',  compact(['titular', 'contacto', 'tipoContacto', 'iva']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cuit)
    {
        $titular = Titular::findOrFail($cuit);
        $contacto = Titular_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        $iva = Condicion_IVA::all();
        return view('titular.edit', compact(['titular', 'contacto', 'tipoContacto', 'iva']));
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
        $nuevo = Titular::findOrFail($cuit);
        $nuevo->nombre = $request->input('nombre');
        $nuevo->dgr = $request->input('dgr');
        $nuevo->cp = $request->input('cp');
        $nuevo->condIva = $request->input('iva');
        $nuevo->domicilio = $request->input('domicilio');
        $nuevo->localidad = $request->input('localidad');
        $nuevo->provincia = $request->input('provincia');
        $nuevo->pais = $request->input('pais');
        $nuevo->save();
        alert()->success("El titular $nuevo->nombre fue editado con exito", 'Editado con exito');
        return redirect()->action('TitularController@show', $cuit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cuit)
    {
        $titular = Titular::findOrFail($cuit);
        $titular->borrado = true;
        $titular->save();
        alert()->success("El titular de carta porte fue eliminado con exito", 'Eliminado con exito');
        return redirect('/titular');
    }

    public function contact($cuit){
        $tipoContacto = Tipo_Contacto::all();
        $titularContacto = Titular_Contacto::where('cuit', $cuit)->get();
        return view('titular.contact', compact(['tipoContacto', 'titularContacto', 'cuit']));
    }

    public function add_contact(Request $request, $cuit)
    {
        $existe = Titular_Contacto::where('cuit', $cuit)->where('contacto', $request->contacto)->exists();
        if($existe){
            alert()->error("El contacto ya existe para este titular", "Ha ocurrido un error");
        }
        else{
            $nuevo = new Titular_Contacto;
            $nuevo->cuit = $cuit;
            $nuevo->contacto = $request->contacto;
            $nuevo->tipo = $request->tipo;
            $nuevo->save();
            alert()->success("El contacto fue agregado con exito", 'Contacto agregado');
        }
        return back();
    }

    public function delete_contact($id)
    {
        $delete = Titular_Contacto::where('id', $id)->first();
        $delete->delete();
        alert()->success("El contacto fue eliminado con exito", 'Contacto eliminado');
        return back();
    }
}
