<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use App\User;

class PasswordController extends Controller
{
    public function forgotPassword( Request $request){
        $email = $request->email;
        $password = str_random(8);

        $user = User::where( 'email', $email )->first();
        $user->password = bcrypt( $password );
        $user->save();

        \Mail::to($email)->send(new ForgotPassword($password));

        return response()->json([
            'success' => true,
            'message' => 'Your password has been changed, please check the spam. '
        ]);
    }
}
