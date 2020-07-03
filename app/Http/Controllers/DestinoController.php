<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Destino;
use App\Destino_Contacto;
use App\Condicion_IVA;
use App\Tipo_Contacto;
use DB;

class DestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrayDestino = DB::table('destinatario')->where('borrado', false)->orderBy('nombre')->get();
        return view('destino.index', array('arrayDestino'=>$arrayDestino));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('destino.create');
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
            'cuit' => 'required | max:20',
            'nombre' => 'required | max:200',
            'cp' => 'numeric | max:10',
            'iva' => 'required',
        ]);
         */
        $existe = Destino::where('cuit', $request->cuit)->exists();
        if($existe){
            $nuevo = Destino::where('cuit', $request->cuit)->first();
        }
        else{
            $nuevo = new Destino;
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
        alert()->success("El destinatario $nuevo->nombre fue creado con exito", 'Creado con exito');
        return redirect()->action('DestinoController@contact', $request->cuit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function show($cuit)
    {
        $destino = Destino::findOrFail($cuit);
        $contacto = Destino_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        $iva = Condicion_IVA::all();
        return view('destino.show', compact(['destino', 'contacto', 'tipoContacto', 'iva']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function edit($cuit)
    {
        $destino = Destino::findOrFail($cuit);
        $contacto = Destino_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        $iva = Condicion_IVA::all();
        return view('destino.edit', compact(['destino', 'contacto', 'tipoContacto', 'iva']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $cuit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cuit)
    {
        $nuevo = Destino::findOrFail($cuit);
        $nuevo->nombre = $request->input('nombre');
        $nuevo->dgr = $request->input('dgr');
        $nuevo->cp = $request->input('cp');
        $nuevo->condIva = $request->input('iva');
        $nuevo->domicilio = $request->input('domicilio');
        $nuevo->localidad = $request->input('localidad');
        $nuevo->provincia = $request->input('provincia');
        $nuevo->pais = $request->input('pais');
        $nuevo->save();
        alert()->success("El destinatario $nuevo->nombre fue editado con exito", 'Editado con exito');
        return redirect()->action('DestinoController@show', $cuit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function destroy($cuit)
    {
        $destino = Destino::findOrFail($cuit);
        $destino->borrado = true;
        $destino->save();
        alert()->success("El destinatario fue eliminado con exito", 'Eliminado con exito');
        return redirect('/destino');
    }

    public function contact($cuit){
        $tipoContacto = Tipo_Contacto::all();
        $destinoContacto = Destino_Contacto::where('cuit', $cuit)->get();
        return view('destino.contact', compact(['tipoContacto', 'destinoContacto', 'cuit']));
    }

    public function add_contact(Request $request, $cuit)
    {
        $existe = Destino_Contacto::where('cuit', $cuit)->where('contacto', $request->contacto)->exists();
        if($existe){
            alert()->error("El contacto ya existe para este destino", "Ha ocurrido un error");
        }
        else{
            $nuevo = new Destino_Contacto;
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
        $delete = Destino_Contacto::where('id', $id)->first();
        $delete->delete();
        alert()->success("El contacto fue eliminado con exito", 'Contacto eliminado');
        return back();
    }
}
