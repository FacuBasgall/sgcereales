<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Intermediario;
use App\Intermediario_Contacto;
use App\Tipo_Contacto;
use App\Condicion_IVA;

use DB;
use SweetAlert;

class IntermediarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->search;
        if($request->search == ''){
            $arrayIntermediario = Intermediario::where('borrado', false)->orderBy('nombre')->paginate(2);
        }else{
            $intermediario =  Intermediario::where('borrado', false)->where('nombre', 'LIKE', "%$query%")->orWhere('cuit', 'LIKE', "%$query%")->exists();
            if($intermediario){
                $arrayIntermediario = Intermediario::where('borrado', false)->where('nombre', 'LIKE', "%$query%")
                    ->orWhere('cuit', 'LIKE', "%$query%")->orderBy('nombre')->paginate(2);
            }else{
                $arrayIntermediario = Intermediario::where('borrado', false)->orderBy('nombre')->paginate(2);
                alert()->warning("No se encontraron resultados para: $query", 'No se encontraron resultados')->persistent('Cerrar');
            }
        }
        return view('intermediario.index', compact('arrayIntermediario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $iva = Condicion_IVA::orderBy('descripcion')->get();
        return view('intermediario.create', array('iva'=>$iva));    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existe = Intermediario::where('cuit', $request->cuit)->exists();
        $nuevo = Intermediario::where('cuit', $request->cuit)->first();
        if($existe){
            if(!$nuevo->borrado){
                alert()->error("El intermediario $request->nombre ya existe", 'Ha surgido un error')->persistent('Cerrar');
                return back()->withInput();
            }
        }
        else{
            $nuevo = new Intermediario;
            $nuevo->cuit = $request->cuit;
        }
        $nuevo->nombre = $request->nombre;
        $nuevo->dgr = $request->dgr;
        $nuevo->cp = $request->cp;
        $nuevo->condIva = $request->iva;
        $nuevo->domicilio = $request->domicilio;
        $nuevo->localidad = $request->localidad;
        $nuevo->provincia = $request->provincia;
        $nuevo->pais = $request->pais;        $nuevo->borrado = false;
        $nuevo->save();
        alert()->success("El intermediario $nuevo->nombre fue creado con exito", 'Creado con exito');
        return redirect()->action('IntermediarioController@contact', $request->cuit);
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
        $iva = Condicion_IVA::all();
        return view('intermediario.show', compact(['intermediario', 'contacto', 'tipoContacto', 'iva']));
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
        $iva = Condicion_IVA::all();
        return view('intermediario.edit', compact(['intermediario', 'iva']));
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
        $nuevo->nombre = $request->nombre;
        $nuevo->dgr = $request->dgr;
        $nuevo->cp = $request->cp;
        $nuevo->condIva = $request->iva;
        $nuevo->domicilio = $request->domicilio;
        $nuevo->localidad = $request->localidad;
        $nuevo->provincia = $request->provincia;
        $nuevo->pais = $request->pais;
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
        $tipoContacto = Tipo_Contacto::orderBy('descripcion')->get();
        $intermediario = Intermediario::findOrFail($cuit);
        $intermediarioContacto = Intermediario_Contacto::where('cuit', $cuit)->get();
        return view('intermediario.contact', compact(['tipoContacto', 'intermediarioContacto', 'intermediario']));
    }

    public function add_contact(Request $request, $cuit)
    {
        $existe = Intermediario_Contacto::where('cuit', $cuit)->where('contacto', $request->contacto)->exists();
        if($existe){
            alert()->error("El contacto ya existe para este intermediario", "Ha ocurrido un error")->persistent('Cerrar');
            return back()->withInput();
        }
        else{
            $nuevo = new Intermediario_Contacto;
            $nuevo->cuit = $cuit;
            $error = NULL;
            switch ($request->tipo) {
                case '1':
                    if(!is_numeric($request->contacto)){
                        $error = "No es un número de celular valido";
                    }
                    break;

                case '2':
                    if(!is_numeric($request->contacto)){
                        $error = "No es un número de telefono valido";;
                    }
                    break;

                case '3':
                    if(!filter_var($request->contacto, FILTER_VALIDATE_EMAIL)){
                        $error = "No es una dirección de correo valida";
                    }
                    break;

                case '4':
                    if(!is_string($request->contacto)){
                        $error = "No es una página web valida";
                    }
                    break;

                case '5':
                    if(!is_numeric($request->contacto)){
                        $error = "No es un número de fax valido";
                    }
                    break;
            }
            if($error == NULL){
                $nuevo->contacto = $request->contacto;
                $nuevo->tipo = $request->tipo;
                $nuevo->save();
                alert()->success("El contacto fue agregado con exito", 'Contacto agregado');
                return back();
            }else{
                alert()->error($error, "Ha ocurrido un error")->persistent('Cerrar');
                return back()->withInput();
            }
        }
    }

    public function delete_contact($id)
    {
        $delete = Intermediario_Contacto::where('id', $id)->first();
        $delete->delete();
        alert()->success("El contacto fue eliminado con exito", 'Contacto eliminado');
        return back();
    }
}
