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
       // $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        //return 'username';
    }

    public function login()
    {
       // return view('auth.login');
    }

    public function authenticate(Request $request)
    {
       /* $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        dd(Auth::attempt($credentials));
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/home');
        }

        return redirect('/login')->with('error', 'Oppes! You have entered invalid credentials');*/
    }

    public function logout()
    {
       /* Auth::logout();

        return redirect('/login');*/
    }
}
