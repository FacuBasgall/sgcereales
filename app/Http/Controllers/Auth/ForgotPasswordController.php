<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Str;
use DB;
use Mail;
use App\User;
use App\Entregador_Contacto;
use SweetAlert;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    // Comentamos esto que no nos hace falta
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Añadimos las respuestas JSON, ya que el Frontend solo recibe JSON
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|exists:usuario'
        ]);
        $user = User::where('username', $request->username)->first();
        $existe = Entregador_Contacto::where('idUser', $user->idUser)->where('contacto', $request->email)->exists();
        if($existe){
            $token = Str::random(60);
            DB::table('password_resets')->insert(
                ['username' => $request->username, 'token' => $token, 'created_at' => Carbon::now()]
            );
            Mail::send('auth.verify',['token' => $token], function($message) use ($request) {
                      $message->from($request->email);
                      $message->to('sgcereales@gmail.com');
                      $message->subject('Notificación de reestablecimiento de contraseña');
                   });
            alert()->success("Se ha enviado por correo el enlace para restablecer la contraseña", 'Correo enviado con éxito')->persistent('Cerrar');
            return redirect()->action('LoginController@login');
        }else{
            alert()->error("El correo ingresado es incorrecto", 'Ha ocurrido un error')->persistent('Cerrar');
            return back()->withInput();
        }
    }
}
