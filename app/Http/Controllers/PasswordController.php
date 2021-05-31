<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use App\User;

class PasswordController extends Controller
{

    /**
     * Forgot Password
     * @param Request $request
     * @return JsonResponse
     *
     *  @OA\Post (
     *  path="/password",
     *  tags={"Auth"},
     *  operationId="forgotPassword",
     *  summary="Forgot the password",
     *  description="If user forgot his password, a new password will be generated and send by mail",
     *  @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     description="Email of user",
     *                     type="string"
     *                 )
     *             )
     *         )
     *   ),
     *      @OA\Response(
     *          response=200,
     *          description="Your password has been changed, please check your email",
     *
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="User's email not provided",
     *      ),
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

        $email = $request->email;
        $password = str_random(8);

        try{
            \Mail::to($email)->send(new ForgotPassword($password));

            $user = User::where('email', $email)->first();
            $user->password = bcrypt($password);
            $user->save();
        }catch(Exception $exception){
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
}
