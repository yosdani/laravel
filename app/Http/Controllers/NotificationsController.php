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