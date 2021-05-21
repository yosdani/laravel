<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\RoleUser;
use App\Role;
use App\Mail\ForgotPassword;

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

        $role_user = new RoleUser();

        if( $request-> role){
            $role = Role::where( 'name', '=', $request->role)->first();
            $role_user-> user_id = $user->id;
            $role_user-> role_id = $role->id;

            $role_user -> save();
        }else{
            $role_user-> role_id = 2;
            $role_user -> user_id = $user->id;
            $role_user ->save();
        }

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

            $user -> token_user = $jwt_token;
            $user ->save();
            return response()->json([
            'success' => true,
            'token' => $jwt_token,
            ]);          
    }

    public function logout( Request $request ){
        try {	            
            JWTAuth::invalidate($request->token);
            $user = User::where( 'email', '=', $request->email)->first();
            $user -> token_user = null;
            $user -> save();
            return response([
                'status' => 'success',
                'msg' => 'You have successfully logged out.'
            ]);	        
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token	            
            return response([
                'status' => 'error',
                'msg' => 'Failed to logout, please try again.'
            ]);	        
        }
    }

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
