<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthUserController extends Controller
{
    public $loginAfterSignUp = true;
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

        //register the user
        $user -> save();

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }
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


            $input = $request->only('email', 'password');
            $jwt_token = null;
            if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
            'success' => false,
            'message' => 'Invalid Email or Password',
            ], 401);
            }
            return response()->json([
            'success' => true,
            'token' => $jwt_token,
            ]);
           
    }
}
