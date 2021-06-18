<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Facades\FCM;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    protected $fillable=['user_id','device_token'];
    public  static function toSingleDevice($token=null,$title=null,$body=null,$icon,$clickAction)
    {
        $optionBuilder=new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder=new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body   )
                            ->setSound('default')
                            ->setBadge(1)
                            ->setIcon($icon)
                            ->setClickAction($clickAction);
        $dataBuilder=new PayloadDataBuilder();
        $dataBuilder->addData(['a_data'=>'my_data']);

        $option=$optionBuilder->build();
        $notification=$notificationBuilder->build();
        $data=$dataBuilder->build();

        $token=$token;

        $downStreamResponse= FCM::sendTo($token,$option,$notification,$data);
        $downStreamResponse->numberSucess();
        $downStreamResponse->numberFaillure();
        $downStreamResponse->numberModification();
        $downStreamResponse->tokensToDelete();
        $downStreamResponse->tokensToModify();
        $downStreamResponse->tokensToRetry();


    }

    public  static function toMultiDevice($model,$token=null,$title=null,$body=null,$icon,$clickAction)
    {
        $optionBuilder=new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder=new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body   )
            ->setSound('default')
            ->setBadge(1)
            ->setIcon($icon)
            ->setClickAction($clickAction);
        $dataBuilder=new PayloadDataBuilder();
        $dataBuilder->addData(['a_data'=>'my_data']);

        $option=$optionBuilder->build();
        $notification=$notificationBuilder->build();
        $data=$dataBuilder->build();

        $tokens=$model->pluck('device_token')->toArray();

        $downStreamResponse= FCM::sendTo($token,$option,$notification,$data);
        $downStreamResponse->numberSucess();
        $downStreamResponse->numberFaillure();
        $downStreamResponse->numberModification();
        $downStreamResponse->tokensToDelete();
        $downStreamResponse->tokensToModify();
        $downStreamResponse->tokensToRetry();
        $downStreamResponse->tokensWithError();
    }


}
