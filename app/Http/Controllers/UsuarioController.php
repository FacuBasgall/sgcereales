<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use App\User;
use App\Entregador_Contacto;
use App\Entregador_Domicilio;
use App\Tipo_Contacto;
use App\Localidad;
use App\Provincia;
use App\Usuario_Preferencias_Correo;
use DB;
use SweetAlert;
use \Auth;


class UsuarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
    public function create()
    {
        return view('usuario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|string|max:255|unique:usuario',
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'cuit' => 'required|min:11|max:11',
            'nombre' => 'required',
            'descripcion' => 'required|max:250',
        ];

        $messages = [
            'username.required' => 'El campo nombre de usuario no puede ser vacio.',
            'username.max' =>'El nombre de usuario no puede ser mayor a :max caracteres.',
            'username.unique' => 'El nombre de usuario ya está en uso.',
            'email.required' => 'El campo correo electrónico no puede ser vacio.',
            'email.max' =>'El correo electrónico no puede ser mayor a :max caracteres.',
            'password.required' => 'El campo contraseña no puede ser vacio.',
            'password.min' => 'La contraseña debe ser mayor a :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'cuit.required' => 'El campo CUIT no puede ser vacio.',
            'cuit.min' => 'El campo CUIT debe ser mayor a :min caracteres.',
            'cuit.max' => 'El campo CUIT debe ser menor a :max caracteres.',
            'nombre.required' => 'El campo nombre y apellido no puede ser vacio.',
            'descripcion.required' => 'El campo descripción no puede ser vacio.',
            'descripcion.max' => 'No puede ser mayor a :max caracteres.',
        ];

        $this->validate($request, $rules, $messages);

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            alert()->error("El correo electrónico ingresado no es una dirección valida", "Ha ocurrido un error")->persistent('Cerrar');
            return back()->withInput();
        }else{
            $nuevo = new User;
            $nuevo->username = $request->username;
            $nuevo->password = Hash::make($request->password);
            $nuevo->tipoUser = 'E';
            $nuevo->cuit = $request->cuit;
            $nuevo->nombre = $request->nombre;
            $nuevo->descripcion = $request->descripcion;
            $nuevo->save();

            $contacto = new Entregador_Contacto;
            $contacto->idUser = $nuevo->idUser;
            $contacto->tipo = 3;
            $contacto->contacto = $request->email;
            $contacto->save();

            $preferencia = new Usuario_Preferencias_Correo;
            $preferencia->idUser = $nuevo->idUser;
            $preferencia->email = $contacto->id;
            $preferencia->asunto = "Envio del aviso nro: {{NRO_AVISO}}";
            $preferencia->cuerpo = "A continuación se adjuntan los romaneos correspondientes al aviso nro: {{NRO_AVISO}}. Por favor no responder este correo. Comunicarse con {{CORREO}}";
            $preferencia->save();

            alert()->success("El usuario fue creado con éxito", 'Usuario creado');
            return redirect()->action('UsuarioController@create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $idUser = auth()->user()->idUser;
        $entregadorContacto = Entregador_Contacto::where('idUser', $idUser)->get();
        $tipoContacto = Tipo_Contacto::all();
        $entregadorDomicilio = Entregador_Domicilio::where('idUser', $idUser)->get();
        $localidades = Localidad::all();
        $provincias = Provincia::all();
        $preferencia = Usuario_Preferencias_Correo::where('idUser', $idUser)->first();
        $correo = Entregador_Contacto::where('idUser', $idUser)->where('tipo', 3)->where('id', $preferencia->email)->first();
        return view('usuario.show',  compact(['entregadorContacto', 'tipoContacto', 'entregadorDomicilio',
            'localidades', 'provincias', 'preferencia', 'correo']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('usuario.edit');
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
        $idUser = auth()->user()->idUser;
        $entregador = User::where('idUser', $idUser)->first();
        $entregador->nombre = $request->nombre;
        $entregador->descripcion = $request->descripcion;
        $entregador->save();
        alert()->success("El usuario fue editado con éxito", 'Editado con éxito');
        return redirect()->action('UsuarioController@show');
    }

    public function contact()
    {
        $idUser = auth()->user()->idUser;
        $tipoContacto = Tipo_Contacto::orderBy('descripcion')->get();
        $entregadorContacto = Entregador_Contacto::where('idUser', $idUser)->get();
        return view('usuario.contact', compact(['tipoContacto', 'entregadorContacto']));
    }

    public function add_contact(Request $request)
    {
        $idUser = auth()->user()->idUser;
        $existe = Entregador_Contacto::where('idUser', $idUser)->where('contacto', $request->contacto)->exists();
        if($existe){
            alert()->error("El contacto ya existe para este usuario", "Ha ocurrido un error")->persistent('Cerrar');
            return back()->withInput();
        }
        else{
            $nuevo = new Entregador_Contacto;
            $nuevo->idUser = $idUser;
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
        $delete = Entregador_Contacto::where('id', $id)->first();
        $mensaje = "El contacto fue eliminado con éxito.";
        if($delete->tipo == 3){
            $esPreferencia = Usuario_Preferencias_Correo::where('email', $delete->id)->exists();
            if($esPreferencia){
                alert()->error("No se puede eliminar el correo porque está definido como preferencia.", 'Ha ocurrido un error')->persistent('Cerrar');
                return back();
            }
        }
        $delete->delete();
        alert()->success($mensaje, 'Contacto eliminado');
        return back();
    }

    public function domicile(){
        $idUser = auth()->user()->idUser;
        $localidades = Localidad::all();
        $provincias = Provincia::all();

        $entregadorDomicilio = DB::table('entregador_domicilio')
                            ->join('provincia', 'entregador_domicilio.provincia', '=', 'provincia.id')
                            ->join('localidad', 'entregador_domicilio.localidad', '=', 'localidad.id')
                            ->where('entregador_domicilio.idUser', '=', $idUser)
                            ->select('entregador_domicilio.idDomicilio', 'entregador_domicilio.cp', 'entregador_domicilio.domicilio', 'entregador_domicilio.pais', 'localidad.nombre as localidad', 'provincia.nombre as provincia', 'provincia.abreviatura as abreviatura')
                            ->get();


        return view('usuario.domicile', compact(['localidades', 'provincias', 'entregadorDomicilio']));
    }

    public function add_domicile(Request $request)
    {
        $idUser = auth()->user()->idUser;
        $existe = Entregador_Domicilio::where('idUser', $idUser)->where('localidad', $request->localidad)->where('domicilio', $request->domicilio)->exists();
        if($existe){
            alert()->error("El domicilio ya existe para este usuario", "Ha ocurrido un error")->persistent('Cerrar');
            return back()->withInput();
        }
        else{
            $nuevo = new Entregador_Domicilio;
            $nuevo->idUser = $idUser;
            $nuevo->cp = $request->cp;
            $nuevo->domicilio = $request->domicilio;
            $nuevo->localidad = $request->localidad;
            $nuevo->provincia = $request->provincia;
            $nuevo->pais = $request->pais;
            $nuevo->save();
            alert()->success("El domicilio fue agregado con éxito", 'Domicilio agregado');
            return back();
        }
    }

    public function delete_domicile($id)
    {
        $delete = Entregador_Domicilio::where('idDomicilio', $id)->first();
        $delete->delete();
        alert()->success("El domicilio fue eliminado con éxito", 'Domicilio eliminado');
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

    public function form_password()
    {
        return view('usuario.password');
    }

    public function change_password(Request $request)
    {
        $rules = [
            'passwordold' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ];

        $messages = [
            'passwordold.required' => 'Reingrese su contraseña.',
            'password.required' => 'Agrega una contraseña.',
            'password.min' => 'La contraseña debe ser mayor a :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];

        $this->validate($request, $rules, $messages);
        if (Hash::check($request->passwordold, Auth::user()->password))
        {
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();

            if($user->save()){
                alert()->success("La contraseña ha sido cambiada correctamente", 'Contraseña cambiada')->persistent('Cerrar');
                return redirect()->back();
            }else
            {
                alert()->error("No se pudo guardar la contraseña", 'Ha ocurrido un error')->persistent('Cerrar');
                return back();
            }
        }
        else
        {
            alert()->error("La contraseña ingresada no es correcta", 'Ha ocurrido un error')->persistent('Cerrar');
            return back();
        }
    }

    public function edit_email_preferences()
    {
        $idUser = auth()->user()->idUser;
        $preferencia = Usuario_Preferencias_Correo::where('idUser', $idUser)->first();
        $entregadorContacto = Entregador_Contacto::where('idUser', $idUser)->where('tipo', 3)->get();
        return view('usuario.email', compact(['preferencia', 'entregadorContacto']));
    }

    public function store_email_preferences(Request $request)
    {
        $idUser = auth()->user()->idUser;
        $preferencia = Usuario_Preferencias_Correo::where('idUser', $idUser)->first();
        $preferencia->email = $request->email;
        $preferencia->asunto = $request->asunto;
        $preferencia->cuerpo = $request->cuerpo;
        $preferencia->save();
        alert()->success("Las preferencias de correo fueron editadas con exito", 'Editado con éxito');
        return redirect()->action('UsuarioController@show');
    }
}
