<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\RoleUser;
use App\Role;

class AuthUserController extends Controller
{
    public $loginAfterSignUp = true;

    /**
     * Register the new user
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/register",
     *      tags={"Auth"},
     *      summary="Register new user",
     *      description="Register in system a new user",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Name of user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="last Name",
     *                     description="Last Name of user",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="email",
     *                     description="Email of user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="Password of user",
     *                     type="string"
     *                 ),
     *                  @OA\Property(
     *                     property="phoneNumber",
     *                     description="Phone number of user",
     *                     type="string"
     *                 ),
     *             )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
     */

    public function register(Request $request): JsonResponse
    {
        //create a new user
        $user = new User();

        //get the dates of requests
        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->phoneNumber = $request->phoneNumber;

        //bcrypt the password hashed
        $user->password = bcrypt($request->password);

        //register the user
        $user->save();

        $role_user = new RoleUser();

        if ($request->role) {
            $role = Role::where('name', '=', $request->role)->first();
            $role_user->user_id = $user->id;
            $role_user->role_id = $role->id;

            $role_user->save();
        } else {
            $role_user->role_id = 2;
            $role_user->user_id = $user->id;
            $role_user->save();
        }

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }
        //return the user
        return response()->json($user, 200);
    }

    /**
     * Login the user
     * @param Request $request
     * @return JsonResponse
     ** @OA\Post (
     *      path="/login",
     *      tags={"Auth"},
     *      summary="Login user",
     *      description="Login the user",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                  @OA\Property(
     *                     property="email",
     *                     description="Email of user",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="Password of user",
     *                     type="string"
     *                 ),
     *             )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *       @OA\Response(
     *          response=404,
     *          description="Email or password incorrect"
     *      )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        //get user by email
        $user = User::where('email', $request->email)->first();

        //Check that the email is valid
        if (!$user) {
            return response() -> json('The email address is not valid...', 404);
        }

        //if exist the email then check the password
        if (!Hash::check($request -> password, $user->password)) {
            return response() -> json('The password is not valid...', 404);
        }

        $jwt_token = null;

        $jwt_token = JWTAuth::fromUser($user);
        $user -> token_user = $jwt_token;
        $user ->save();
        return response()->json([
            'success' => true,
            'token' => $jwt_token
        ], 200);
    }

    /**
     * Logout user
     * @return JsonResponse
     *  @OA\Get (
     *      path="/logout",
     *      tags={"Auth"},
     *      summary="Logout user",
     *      description="Logout user of system",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function logout(): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            JWTAuth::invalidate(JWTAuth::parseToken());
            $user -> token_user = null;
            $user -> save();
            return response()->json([
                'status' => 'success',
                'msg' => 'You have successfully logged out.'
            ], 200);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'status' => 'error',
                'msg' => 'Failed to logout, please try again.'
            ], 401);
        }
    }
}
