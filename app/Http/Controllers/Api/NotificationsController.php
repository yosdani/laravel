<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/11/2021
 * Time: 11:19 PM
 */

namespace App\Http\Controllers\Api;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotificationsController extends Controller
{


    /**
     * Save a token device
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/token",
     *      tags={"Post Token"},
     *      summary="Store a token device",
     *      description="Returns ",
     *     @OA\Parameter(
     *          name="request",
     *          description="request all data",
     *          required=true,
     *          in="path",
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
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function postToken(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($request->has('device_token')) {
            $user->device_token = $request->input('device_token');
            $user->save();
        }
    }

    public function sendAll(Request $request)
    {
        $recipients = User::whereNotNull('fcm_token')
            ->pluck('fcm_token')->toArray();

        fcm()
            ->to($recipients)
            ->notification([
                'title' => $request->input('title'),
                'body' => $request->input('body')
            ])
            ->send();

        $notification = 'Notifications for all users.';
        return back()->with(compact('notification'));
    }

    /**
     * Save a token device
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/user/disable/notify/{notify}",
     *      tags={"Subscriptions"},
     *      summary="Enable/Disable Notifications alert for authenticated user",
     *      description="Returns ",
     *     @OA\Parameter(
     *          name="notify",
     *          description="boolean value 0(enable notifications) or 1(disable notifications)",
     *          required=true,
     *          in="path",
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
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function disableNotificationAlert($notify = 0): JsonResponse
    {
        $user = User::findOrFail(JWTAuth::parseToken()->authenticate()->id);
        $user->allow_notify = $notify;
        $user->update();
        $mess = $notify == 0 ? 'activado' : 'desactivado';

        return response()->json([
            'success' =>true,
            'message' => 'Se han '.$mess.' las notificaciones para el usuario'
        ], 200);
    }
}
