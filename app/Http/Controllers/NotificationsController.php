<?php

namespace App\Http\Controllers;

use App\Notifications\GeneralNotification;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;


class NotificationsController extends Controller
{
    public function create(Request $request): JsonResponse
    {

        $title = $request->title;
        $body = $request->body;
        $via = $request->via;

        if($via == 'email'){
           $message = $this->sendAllByEmail($title, $body);
        }else{
            $message = $$this->sendAllByPush($title, $body);
        }


        return response()->json([
            'success' => true,
            'message' => $message === 'Ok' ? __('general.notifications.sent') : $message,
        ], 200);
    }

    public function sendAllByPush(string $title, string $body): string
    {
        $recipients = User::whereNotNull('fcm_token')
            ->pluck('fcm_token')->toArray();

        fcm()
            ->to($recipients)
            ->notification([
                'title' => $$title,
                'body' => $body
            ])
            ->send();

        return 'Ok';
    }

    public function sendAllByEmail(string $title, string $body): string
    {
        $users = User::whereHas('incidences')->get();
        try{
            Notification::send($users, new GeneralNotification($title, $body));
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return $exception->getMessage();
        }

        return 'Ok';
    }
}
