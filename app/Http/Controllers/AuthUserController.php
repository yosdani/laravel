<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthUserController extends Controller
{
    //function for register the new user
    public function register( Request $request ){
        //create a new user
        $user = new User();

        //get the dates of requests
        $user -> name = $request-> name;
        $user -> lastName = $request-> lastName;
        $user -> email = $request-> email;
        $user -> phoneNumber = $request-> phoneNumber;

        //bcrypt the password hashed
        $user -> password = bcrypt( $request -> password );

        //make a token for the user
        //$user -> remember_token = JWTAuth::encode( $user -> email, $user -> password );

        //register the user
        $user -> save();

        //return the user
        return response() -> json( $user, 200);
    }

    public function login( Request $request ){
        //get user by email
        $user = User::where( 'email', $request->email )->first();

        //Check that the email is valid
        if( !$user )
            return response() -> json( 'El email no es valido...', 404 );

        //if exist the email then check the password
        if( !Hash::check( $request -> password, $user->password ) )
            return response() -> json( 'El password es incorrecto...', 404 );

        return response() -> json( $user, 200 );
    }
}
