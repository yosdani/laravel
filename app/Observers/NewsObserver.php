<?php

namespace App\Observers;

use App\Incidence;
use App\News;
use App\Notifications\NewsNotification;
use App\User;
use Illuminate\Support\Facades\Log;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class NewsObserver
{
    public $afterCommit = true;

    /**
     * Handle the Incidence "created" event.
     *
     * @param News $news
     * @return void
     */
    public function created(News $news)
    {

        $users = User::leftjoin('user_categories','users.id','=','user_categories.user_id')
            ->where('user_categories.category_id','=',$news->category_id)->get();

        foreach ($users as $user){
            try {
                $news->notify(new NewsNotification($user));

                $this->sendByPush(
                    __('mails.news_notification').$news->category->name,
                    $news->title,
                    [
                        $user
                    ]);
            }catch (\Exception $exception){

            }
        }

    }

    public function sendByPush(string $title, string $body, array $users): string
    {
        foreach ($users as $user){
            if($user->device_token){
                try{
                    $optionBuilder = new OptionsBuilder();
                    $optionBuilder->setTimeToLive(60*20);
                    $dataBuilder = new PayloadDataBuilder();
                    $dataBuilder->addData([]);
                    $notificationBuilder = new PayloadNotificationBuilder($title);
                    $notificationBuilder->setBody($body)
                        ->setSound('default');
                    $option = $optionBuilder->build();
                    $notification = $notificationBuilder->build();
                    $data = $dataBuilder->build();

                    $token = $user->device_token;

                    $response = FCM::sendTo($token, $option, $notification, $data);
                    Log::info('Respuesta de FCM '.$response);
                    return $response;
                }catch(\Exception $exception){
                    Log::error('Ha fallado el envio de notificaciones push al usuario '.$user->email);
                }


            }
        }
        return 'Ok';

    }

}
