<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Titular;
use App\Titular_Contacto;
use App\Condicion_IVA;
use App\Tipo_Contacto;
use App\Localidad;
use App\Provincia;

use DB;
use SweetAlert;

class TitularController extends Controller
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
            $arrayTitular = Titular::where('borrado', false)->orderBy('nombre')->paginate(10);
        }else{
            $titular =  Titular::where('borrado', false)->where('nombre', 'LIKE', "%$query%")->orWhere('cuit', 'LIKE', "%$query%")->exists();
            if($titular){
                $arrayTitular = Titular::where('borrado', false)->where('nombre', 'LIKE', "%$query%")
                    ->orWhere('cuit', 'LIKE', "%$query%")->orderBy('nombre')->paginate(10);
            }else{
                $arrayTitular = Titular::where('borrado', false)->orderBy('nombre')->paginate(10);
                alert()->warning("No se encontraron resultados para: $query", 'No se encontraron resultados')->persistent('Cerrar');
            }
        }
        return view('titular.index', compact('arrayTitular'));
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
        return view('titular.create', compact(['iva', 'localidades', 'provincias']));
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
        $nuevo = Titular::where('cuit', $request->cuit)->first();
        if($existe){
            if(!$nuevo->borrado){
                alert()->error("El titular de carta porte $request->nombre ya existe", 'Ha surgido un error')->persistent('Cerrar');
                return back()->withInput();
            }
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
        $localidad = Localidad::where('id', $titular->localidad)->first();
        $provincia = Provincia::where('id', $titular->provincia)->first();
        return view('titular.show',  compact(['titular', 'contacto', 'tipoContacto', 'iva',
            'localidad', 'provincia']));
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
        $iva = Condicion_IVA::orderBy('descripcion')->get();
        $localidades = Localidad::all();
        $provincias = Provincia::all();
        return view('titular.edit', compact(['titular', 'iva', 'localidades', 'provincias']));
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
        $nuevo->nombre = $request->nombre;
        $nuevo->dgr = $request->dgr;
        $nuevo->cp = $request->cp;
        $nuevo->condIva = $request->iva;
        $nuevo->domicilio = $request->domicilio;
        $nuevo->localidad = $request->localidad;
        $nuevo->provincia = $request->provincia;
        $nuevo->pais = $request->pais;
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
        $tipoContacto = Tipo_Contacto::orderBy('descripcion')->get();
        $titular = Titular::findOrFail($cuit);
        $titularContacto = Titular_Contacto::where('cuit', $cuit)->get();
        return view('titular.contact', compact(['tipoContacto', 'titularContacto', 'titular']));
    }

    public function add_contact(Request $request, $cuit)
    {
        $existe = Titular_Contacto::where('cuit', $cuit)->where('contacto', $request->contacto)->exists();
        if($existe){
            alert()->error("El contacto ya existe para este titular", "Ha ocurrido un error")->persistent('Cerrar');
            return back()->withInput();
        }
        else{
            $nuevo = new Titular_Contacto;
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
        $delete = Titular_Contacto::where('id', $id)->first();
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
