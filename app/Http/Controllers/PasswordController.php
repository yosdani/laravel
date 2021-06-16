<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use App\User;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{

    /**
     * Forgot Password
     * @param Request $request
     * @return JsonResponse
     *  @OA\Post (
     *      path="/password",
     *      tags={"Auth"},
     *      summary="Forgot password",
     *      description="The user reset the password and send by email",
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
     *          description="The email not exists"
     *      ),
     *       @OA\Response(
     *          response=404,
     *          description="You are not provided a email"
     *      )
     * )
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        if ($request->email == null) {
            return response()->json([
                'success' => false,
                'message' => 'You have not provided your email address...'
            ], 404);
        }

        if (!User::where('email', '=', $request->email)) {
            return response()->json([
                'success' => false,
                'message' => 'The email not exists...'
            ], 400);
        }

        $email = $request->email;
        $password = str_random(8);

        try {
            \Mail::to($email)->send(new ForgotPassword($password));

            $user = User::where('email', $email)->first();
            $user->password = bcrypt($password);
            $user->save();
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Your password has been changed, please check your mails '
        ], 200);
    }

    /**
     * @throws Exception
     */
    public function changeAdminPassword(Request $request): JsonResponse
    {
        $user = Auth::user();
        $checkEmail = User::where('email', '=', $request->email)->first();
        if ($checkEmail->id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Ya existe un usuario con este email'
            ]);

        }
        $name = $request->name;
        $lastName = $request->lastName;
        $email = $request->email;
        $password = $request->password;

        if($password){
            $user->password = bcrypt($request->password);
        }
        $user->email = $email;
        $user->name = $name;
        $user->lastName = $lastName;
        $user->save();


        return response()->json([
            'success' => true,
            'message' => 'Your password has been changed ',
            'user' => new UserResource($user)
        ], 200);
    }
}
