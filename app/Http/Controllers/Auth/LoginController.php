<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('username', 'password');
        $usuario = User::where('username', $request->username)->first();
        if($usuario->habilitado == false){
            //Error si el usuario no está habilitado
            return redirect('login')->withErrors("El usuario no está habilitado. Póngase en contacto con su administrador.");
        }else{
            if (Auth::attempt($credentials)) {
                return redirect()->action('HomeController@verificacion');
            }else{
                //Error
                return redirect('login')->withErrors("El nombre de usuario o contraseña son incorrectos.");
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
