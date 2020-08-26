<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Remitente_Comercial;
use App\Remitente_Contacto;
use App\Tipo_Contacto;
use App\Condicion_IVA;

use DB;
use SweetAlert;

class RemitenteController extends Controller
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
            $arrayRemitente = Remitente_Comercial::where('borrado', false)->orderBy('nombre')->paginate(2);
        }else{
            $remitente =  Remitente_Comercial::where('borrado', false)->where('nombre', 'LIKE', "%$query%")->orWhere('cuit', 'LIKE', "%$query%")->exists();
            if($remitente){
                $arrayRemitente = Remitente_Comercial::where('borrado', false)->where('nombre', 'LIKE', "%$query%")
                    ->orWhere('cuit', 'LIKE', "%$query%")->orderBy('nombre')->paginate(2);
            }else{
                $arrayRemitente = Remitente_Comercial::where('borrado', false)->orderBy('nombre')->paginate(2);
                alert()->warning("No se encontraron resultados para: $query", 'No se encontraron resultados')->persistent('Cerrar');
            }
        }
        return view('remitente.index', compact('arrayRemitente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $iva = Condicion_IVA::orderBy('descripcion')->get();
        return view('remitente.create', array('iva'=>$iva));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existe = Remitente_Comercial::where('cuit', $request->cuit)->exists();
        $nuevo = Remitente_Comercial::where('cuit', $request->cuit)->first();
        if($existe){
            if(!$nuevo->borrado){
                alert()->error("El remitente comercial $request->nombre ya existe", 'Ha surgido un error')->persistent('Cerrar');
                return back()->withInput();
            }
        }
        else{
            $nuevo = new Remitente_Comercial;
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
        alert()->success("El remitente $nuevo->nombre fue creado con exito", 'Creado con exito');
        return redirect()->action('RemitenteController@contact', $request->cuit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function show($cuit)
    {
        $remitente = Remitente_Comercial::findOrFail($cuit);
        $contacto = Remitente_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        $iva = Condicion_IVA::all();
        return view('remitente.show', compact(['remitente', 'contacto', 'tipoContacto', 'iva']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function edit($cuit)
    {
        $remitente = Remitente_Comercial::findOrFail($cuit);
        $iva = Condicion_IVA::all();
        return view('remitente.edit', compact(['remitente', 'iva']));
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
        $nuevo = Remitente_Comercial::findOrFail($cuit);
        $nuevo->nombre = $request->nombre;
        $nuevo->dgr = $request->dgr;
        $nuevo->cp = $request->cp;
        $nuevo->condIva = $request->iva;
        $nuevo->domicilio = $request->domicilio;
        $nuevo->localidad = $request->localidad;
        $nuevo->provincia = $request->provincia;
        $nuevo->pais = $request->pais;
        $nuevo->save();
        alert()->success("El remitente $nuevo->nombre fue editado con exito", 'Editado con exito');
        return redirect()->action('RemitenteController@show', $cuit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function destroy($cuit)
    {
        $remitente = Remitente_Comercial::findOrFail($cuit);
        $remitente->borrado = true;
        $remitente->save();
        alert()->success("El remitente fue eliminado con exito", 'Eliminado con exito');
        return redirect('/remitente');
    }

    public function contact($cuit){
        $tipoContacto = Tipo_Contacto::orderBy('descripcion')->get();
        $remitente = Remitente_Comercial::findOrFail($cuit);
        $remitenteContacto = Remitente_Contacto::where('cuit', $cuit)->get();
        return view('remitente.contact', compact(['tipoContacto', 'remitenteContacto', 'remitente']));
    }

    public function add_contact(Request $request, $cuit)
    {
        $existe = Remitente_Contacto::where('cuit', $cuit)->where('contacto', $request->contacto)->exists();
        if($existe){
            alert()->error("El contacto ya existe para este remitente", "Ha ocurrido un error")->persistent('Cerrar');
            return back()->withInput();
        }
        else{
            $nuevo = new Remitente_Contacto;
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
        $delete = Remitente_Contacto::where('id', $id)->first();
        $delete->delete();
        alert()->success("El contacto fue eliminado con exito", 'Contacto eliminado');
        return back();
    }
}
