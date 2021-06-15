<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/11/2021
 * Time: 11:19 PM
 */

namespace App\Http\Controllers;
use App\User;

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

}