<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Intermediario;
use App\Intermediario_Contacto;
use App\Tipo_Contacto;
use DB;

class IntermediarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayIntermediario = DB::table('intermediario')->where('borrado', false)->orderBy('nombre')->get();
        return view('intermediario.index', array('arrayIntermediario'=>$arrayIntermediario));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intermediario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existe = Intermediario::where('cuit', $request->cuit)->exists();
        if($existe){
            $nuevo = Intermediario::where('cuit', $request->cuit)->first();
        }
        else{
            $nuevo = new Intermediario;
            $nuevo->cuit = $request->cuit;
        }
        $nuevo->nombre = $request->nombre;
        $nuevo->borrado = false;
        $nuevo->save();
        alert()->success("El intermediario $nuevo->nombre fue creado con exito", 'Creado con exito');
        return redirect()->action('IntermediariorController@contact', $request->cuit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function show($cuit)
    {
        $intermediario = Intermediario::findOrFail($cuit);
        $contacto = Intermediario_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        return view('intermediario.show', compact(['intermediario', 'contacto', 'tipoContacto']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function edit($cuit)
    {
        $intermediario = Intermediario::findOrFail($cuit);
        return view('intermediario.edit', array('intermediario'=>$intermediario));
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
        $nuevo = Intermediario::findOrFail($cuit);
        $nuevo->nombre = $request->input('nombre');
        $nuevo->save();
        alert()->success("El intermediario $nuevo->nombre fue editado con exito", 'Editado con exito');
        return redirect()->action('IntermediarioController@show', $cuit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function destroy($cuit)
    {
        $intermediario = Intermediario::findOrFail($cuit);
        $intermediario->borrado = true;
        $intermediario->save();
        alert()->success("El intermediario fue eliminado con exito", 'Eliminado con exito');
        return redirect('/intermediario');
    }

    public function contact($cuit){
        $tipoContacto = Tipo_Contacto::all();
        $intermediarioContacto = Intermediario_Contacto::where('cuit', $cuit)->get();
        return view('intermediario.contact', compact(['tipoContacto', 'intermediarioContacto', 'cuit']));
    }

    public function add_contact(Request $request, $cuit)
    {
        $existe = Intermediario_Contacto::where('cuit', $cuit)->where('contacto', $request->contacto)->exists();
        if($existe){
            alert()->error("El contacto ya existe para este intermediario", "Ha ocurrido un error");
        }
        else{
            $nuevo = new Intermediario_Contacto;
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
        $delete = Intermediario_Contacto::where('id', $id)->first();
        $delete->delete();
        alert()->success("El contacto fue eliminado con exito", 'Contacto eliminado');
        return back();
    }
}
