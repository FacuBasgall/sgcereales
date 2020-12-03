<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    // Comentamos esto que no hace falta
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    protected function reset(Request $request)
    {
        $rules = [
            'username' => 'required|string|exists:usuario',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ];

        $messages = [
            'username.required' => 'Agrega un nombre de usuario.',
            'username.exists' => 'El nombre de usuario no existe.',
            'email.required' => 'Agrega un correo electrónico.',
            'email.email' => 'El correo no es una dirrección valida.',
            'password.required' => 'Agrega una contraseña.',
            'password.min' => 'La contraseña debe ser mayor a :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ];

        $this->validate($request, $rules, $messages);

        $updatePassword = DB::table('password_resets')
                            ->where(['username' => $request->username, 'token' => $request->token])
                            ->first();

        if(!$updatePassword)
            return back()->withInput()->with('error', 'Token invalido!');

          $user = User::where('username', $request->username)
                      ->update(['password' => Hash::make($request->password)]);

          DB::table('password_resets')->where(['username'=> $request->username])->delete();

          return redirect('/login')->with('message', 'Tu contraseña ha sido cambiada!');
    }
}
