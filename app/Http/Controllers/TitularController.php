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

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('entregador');
    }

    public function index()
    {
        $arrayTitular = Titular::where('borrado', false)->orderBy('nombre')->get();
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
            $rules = [
                'cuit' => 'required|min:11|max:11|unique:usuario',
            ];
    
            $messages = [
                'cuit.required' => 'El campo CUIT no puede ser vacio.',
                'cuit.min' => 'El campo CUIT debe ser igual a 11 caracteres.',
                'cuit.max' => 'El campo CUIT debe ser igual a 11 caracteres.',
                'cuit.unique' => 'El campo CUIT ya está en uso.',
            ];
            $this->validate($request, $rules, $messages);
    
            $nuevo = new Titular;
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
        alert()->success("El titular $nuevo->nombre fue creado con éxito", 'Creado con éxito');
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
        $rules = [
            'cuit' => 'required|min:11|max:11',
        ];

        $messages = [
            'cuit.required' => 'El campo CUIT no puede ser vacio.',
            'cuit.min' => 'El campo CUIT debe ser igual a 11 caracteres.',
            'cuit.max' => 'El campo CUIT debe ser igual a 11 caracteres.',
        ];
        $this->validate($request, $rules, $messages);
        $controlCuit = $this->validar_cuit($request->cuit);
        if($controlCuit == 1){
            alert()->error("El CUIT ya se encuentra en uso", 'Ha ocurrido un error');
            return redirect()->action('TitularController@edit');
        }
        
        $nuevo = Titular::findOrFail($cuit);
        $nuevo->nombre = $request->nombre;
        $nuevo->cuit = $request->cuit;
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
        $cuit = $nuevo->cuit;
        alert()->success("El titular $nuevo->nombre fue editado con éxito", 'Editado con éxito');
        return redirect()->action('TitularController@show', $cuit);
    }

    public function validar_cuit($cuit)
    {
        $control = 0; //El cuit no se repite
        $userAuth = auth()->user()->cuit;
        if($userAuth == $cuit){
            $control = 0; //El cuit es igual al del usuario
        }else{
            $usuarios = Titular::all();
            foreach($usuarios as $usuario){
                if($usuario->cuit == $cuit){
                    $control = 1; //El cuit ya esta en uso con otro usuario
                } 
            }
        }
        return $control;
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
        alert()->success("El titular de carta porte fue eliminado con éxito", 'Eliminado con éxito');
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
                alert()->success("El contacto fue agregado con éxito", 'Contacto agregado');
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
        alert()->success("El contacto fue eliminado con éxito", 'Contacto eliminado');
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
