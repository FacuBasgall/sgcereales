<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Corredor;
use App\Corredor_Contacto;
use App\Tipo_Contacto;
use App\Condicion_IVA;
use App\Localidad;
use App\Provincia;

use DB;
use SweetAlert;

class CorredorController extends Controller
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
            $arrayCorredor = Corredor::where('borrado', false)->orderBy('nombre')->paginate(10);
        }else{
            $corredor =  Corredor::where('borrado', false)->where('nombre', 'LIKE', "%$query%")->orWhere('cuit', 'LIKE', "%$query%")->exists();
            if($corredor){
                $arrayCorredor = Corredor::where('borrado', false)->where('nombre', 'LIKE', "%$query%")
                    ->orWhere('cuit', 'LIKE', "%$query%")->orderBy('nombre')->paginate(10);
            }else{
                $arrayCorredor = Corredor::where('borrado', false)->orderBy('nombre')->paginate(10);
                alert()->warning("No se encontraron resultados para: $query", 'No se encontraron resultados')->persistent('Cerrar');
            }
        }
        return view('corredor.index', compact('arrayCorredor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $iva = Condicion_IVA::orderBy('descripcion')->get();
        $localidades = Localidad::all();
        $provincias = Provincia::all();
        return view('corredor.create', compact(['iva', 'localidades', 'provincias']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existe = Corredor::where('cuit', $request->cuit)->exists();
        if($existe){
            $nuevo = Corredor::where('cuit', $request->cuit)->first();
            if(!$nuevo->borrado){
                alert()->error("El corredor $request->nombre ya existe", 'Ha surgido un error')->persistent('Cerrar');
                return back()->withInput();
            }
        }
        else{
            $nuevo = new Corredor;
            $nuevo->cuit = $request->cuit;
        }
        $nuevo->nombre = $request->nombre;
        $nuevo->dgr = $request->dgr;
        $nuevo->condIva = $request->iva;
        if($request->pais == "Argentina"){
            $nuevo->pais = $request->pais;
            $nuevo->cp = $request->cp;
            $nuevo->localidad = $request->localidad;
            $nuevo->provincia = $request->provincia;
        }else{
            $nuevo->pais = $request->otroPais;
        }
        $nuevo->domicilio = $request->domicilio;
        $nuevo->borrado = false;
        $nuevo->save();
        alert()->success("El corredor $nuevo->nombre fue creado con exito", 'Creado con exito');
        return redirect()->action('CorredorController@contact', $request->cuit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function show($cuit)
    {
        $corredor = Corredor::findOrFail($cuit);
        $contacto = Corredor_Contacto::where('cuit', $cuit)->get();
        $tipoContacto = Tipo_Contacto::all();
        $iva = Condicion_IVA::all();
        $localidad = Localidad::where('id', $corredor->localidad)->first();
        $provincia = Provincia::where('id', $corredor->provincia)->first();
        return view('corredor.show', compact(['corredor', 'contacto', 'tipoContacto',
            'iva', 'localidad', 'provincia']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function edit($cuit)
    {
        $corredor = Corredor::findOrFail($cuit);
        $iva = Condicion_IVA::all();
        $localidades = Localidad::all();
        $provincias = Provincia::all();
        return view('corredor.edit', compact(['corredor', 'iva', 'localidades', 'provincias']));
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
        $nuevo = Corredor::findOrFail($cuit);
        $nuevo->nombre = $request->nombre;
        $nuevo->dgr = $request->dgr;
        $nuevo->condIva = $request->iva;
        if($request->pais == "Argentina"){
            $nuevo->pais = $request->pais;
            $nuevo->cp = $request->cp;
            $nuevo->localidad = $request->localidad;
            $nuevo->provincia = $request->provincia;
        }else{
            $nuevo->pais = $request->otroPais;
        }
        $nuevo->domicilio = $request->domicilio;
        $nuevo->save();
        alert()->success("El corredor $nuevo->nombre fue editado con exito", 'Editado con exito');
        return redirect()->action('CorredorController@show', $cuit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $cuit
     * @return \Illuminate\Http\Response
     */
    public function destroy($cuit)
    {
        $corredor = Corredor::findOrFail($cuit);
        $corredor->borrado = true;
        $corredor->save();
        alert()->success("El corredor fue eliminado con exito", 'Eliminado con exito');
        return redirect('/corredor');
    }

    public function contact($cuit){
        $tipoContacto = Tipo_Contacto::orderBy('descripcion')->get();
        $corredor = Corredor::findOrFail($cuit);
        $corredorContacto = Corredor_Contacto::where('cuit', $cuit)->get();
        return view('corredor.contact', compact(['tipoContacto', 'corredorContacto', 'corredor']));
    }

    public function add_contact(Request $request, $cuit)
    {
        $existe = Corredor_Contacto::where('cuit', $cuit)->where('contacto', $request->contacto)->exists();
        if($existe){
            alert()->error("El contacto ya existe para este corredor", "Ha ocurrido un error")->persistent('Cerrar');
            return back()->withInput();
        }
        else{
            $nuevo = new Corredor_Contacto;
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
        $delete = Corredor_Contacto::where('id', $id)->first();
        $delete->delete();
        alert()->success("El contacto fue eliminado con exito", 'Contacto eliminado');
        return back();
    }

    public function getLocalidades(Request $request)
    {
        if($request->ajax()){
            $localidades = Localidad::where('idProvincia', $request->provincia_id)->get();
            foreach($localidades as $localidad){
                $localidadesArray[$localidad->id] = $localidad->nombre;
            }
            return response()->json($localidadesArray);
        }
    }
}
