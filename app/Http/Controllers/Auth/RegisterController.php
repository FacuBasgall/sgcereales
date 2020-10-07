<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function register()
    {

        return view('auth.register');
    }

    protected function store(Request $request)
    {

        $rules = [
            'username' => 'required|string|max:255|unique:usuario',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ];

        $messages = [
            'username.required' => 'Agrega un nombre de usuario.',
            'username.max' =>'El nombre de usuario no puede ser mayor a :max caracteres.',
            'username.unique' => 'El nombre de usuario ya está en uso.',
            'password.required' => 'Agrega una contraseña.',
            'password.min' => 'La contraseña debe ser mayor a :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ];

        $this->validate($request, $rules, $messages);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'tipoUser' => 'E', //E = ENTREGADOR : A = ADMIN
        ]);

        return redirect('/login');
    }
}
