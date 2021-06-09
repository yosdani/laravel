<?php

namespace App\Http\Controllers;

use Exception;
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
}
