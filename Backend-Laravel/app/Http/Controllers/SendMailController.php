<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Mail\UserMessage;
use Illuminate\Support\Facades\Mail as FacadesMail;

class SendMailController extends Controller
{
    public function recoverPassword(Request $request)
    {
        $request->validate([
            'email'=>'required|email'
        ]);

        $email = $request->get('email');

        FacadesMail::to($email)->send(new ResetPassword($email));

        return response()->json(['message' => 'Nous avons envoyé un lien de réinitialisation du mot de passe dans votre boite email.'], 200);
    }

    public function userMessage(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'sub'=>'required|string',
            'data'=>'required|string'
        ]);

        $email = $request->get('email');
        $sub = $request->get('sub');
        $data=$request->get('data');

        FacadesMail::to($email)->send(new UserMessage($email,$sub,$data));

        return response()->json(['message' => 'Message envoyé'], 200);
    }
}
