<?php

namespace App\Observers;
use App\Area;
use App\Historic;
use App\Http\Util\EntityChanges;
use App\Incidence;
use App\Notifications\IncidenceCreatedNotification;
use App\Notifications\IncidenceEditedNotification;
use App\State;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Tymon\JWTAuth\Facades\JWTAuth;

class IncidenceObserver
{
    public $afterCommit = true;

    private $user;

    /**
     * IncidenceObserver constructor.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }


    /**
     * Handle the Incidence "created" event.
     *
     * @param Incidence $incidence
     * @return void
     */
    public function created(Incidence $incidence)
    {
        $admin = User::leftjoin('role_user','users.id','=','role_user.user_id')
            ->where('role_user.role_id','=',1)
            ->first();
        try {
            $incidence->notify(new IncidenceCreatedNotification($admin));

        }catch (\Exception $exception){

        }
    }

    /**
     * Handle the Incidence "updated" event.
     *
     * @param Incidence $incidence
     * @return void
     */
    public function updated(Incidence $incidence)
    {
        $changes = [];
        try{
            $changes = $this->registerTittle($incidence, $changes);
            $changes = $this->registerState($incidence, $changes);
            $changes = $this->registerAssignedTo($incidence, $changes);
            $changes = $this->registerArea($incidence, $changes);
            $changes = $this->registerResponse($incidence, $changes);
            $changes = $this->registerDescription($incidence, $changes);
        }catch (\Exception $exception){
        }

        try{
            if($incidence->created_at->format('d/m/Y H:i:s') !== $incidence->updated_at->format('d/m/Y H:i:s')){
                $this->saveHistoric($incidence, $changes);
                $incidence->notify(new IncidenceEditedNotification($this->user, $changes));
                if($incidence->assignedTo){
                    $incidence->notify(new IncidenceEditedNotification($incidence->assignedTo, $changes));
                }
                $this->sendByPush(
                    'Se ha midificado una incidencia',
                    'La incidencia: '.$incidence->title.' se ha midificado',
                    [
                        $incidence->user
                    ]);
            }
        }catch (\Exception $exception){

        }


    }

    /**
     * Handle the Incidence "deleted" event.
     *
     * @param Incidence $incidence
     * @return void
     */
    public function deleted(Incidence $incidence)
    {
        //
    }

    /**
     * Handle the Incidence "restored" event.
     *
     * @param Incidence $incidence
     * @return void
     */
    public function restored(Incidence $incidence)
    {
        //
    }

    /**
     * Handle the Incidence "force deleted" event.
     *
     * @param Incidence $incidence
     * @return void
     */
    public function forceDeleted(Incidence $incidence)
    {
        //
    }

    /**
     * @param Incidence $incidence
     * @param array $changes
     * @return array
     */
    public function registerAssignedTo(Incidence $incidence, array $changes): array
    {
        if ($incidence->wasChanged('assigned_id')) {
            $oldValue = $incidence->getOriginal('assigned_id');
            $oldValue = null !== $oldValue ? User::find($oldValue)->name : null;
            $change = new EntityChanges(
                'assignedTo',
                $oldValue,
                $incidence->assignedTo->name
            );
            $changes[] = $change->toArray();
        }
        return $changes;
    }

    /**
     * @param Incidence $incidence
     * @param array $changes
     * @return array
     */
    public function registerArea(Incidence $incidence, array $changes): array
    {
        if ($incidence->wasChanged('area_id')) {
            $oldValue = $incidence->getOriginal('area_id');
            $oldValue = null !== $oldValue ? Area::find($oldValue)->name : null;
            $change = new EntityChanges(
                __('general.historic.area'),
                $oldValue,
                $incidence->area->name
            );
            $changes[] = $change->toArray();
        }
        return $changes;
    }

    /**
     * @param Incidence $incidence
     * @param array $changes
     * @return array
     */
    public function registerState(Incidence $incidence, array $changes): array
    {
        if ($incidence->wasChanged('state_id')) {
            $oldValue = $incidence->getOriginal('state_id');
            $oldValue = null !== $oldValue ? State::find($oldValue)->name : null;
            $change = new EntityChanges(
                __('general.states.state'),
                $oldValue,
                $incidence->state->name
            );
            $changes[] = $change->toArray();
        }
        return $changes;
    }

    /**
     * @param Incidence $incidence
     * @param array $changes
     * @return array
     */
    public function registerTittle(Incidence $incidence, array $changes): array
    {
        if ($incidence->wasChanged('title')) {
            $change = new EntityChanges(
                __('general.incidences.title'),
                $incidence->getOriginal('title'),
                $incidence->title
            );
            $changes[] = $change->toArray();
        }
        return $changes;
    }

    /**
     * @param Incidence $incidence
     * @param array $changes
     */
    public function saveHistoric(Incidence $incidence, array $changes): void
    {
        $historic = new Historic();
        $historic->incidence_id = $incidence->id;
        $historic->user_id = $this->user->id;
        $historic->changes = json_encode($changes);
        $historic->save();
    }

    /**
     * @param Incidence $incidence
     * @param array $changes
     * @return array
     */
    private function registerDescription(Incidence $incidence, array $changes): array
    {
        if ($incidence->wasChanged('description')) {
            $change = new EntityChanges(
                __('general.incidences.description'),
                $incidence->getOriginal('description'),
                $incidence->description
            );
            $changes[] = $change->toArray();
        }
        return $changes;
    }

    /**
     * @param Incidence $incidence
     * @param $changes
     * @return mixed
     */
    private function registerResponse(Incidence $incidence, $changes)
    {
        if ($incidence->wasChanged('responseForCitizen')) {
            $change = new EntityChanges(
                __('general.incidences.responseForCitizen'),
                $incidence->getOriginal('responseForCitizen'),
                $incidence->responseForCitizen
            );
            $changes[] = $change->toArray();
        }
        return $changes;
    }

    public function sendByPush(string $title, string $body, array $users): string
    {
        foreach ($users as $user){
            if($user->fcm_token){
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
                    Log::info($response);
                    return $response;
                }catch(\Exception $exception){
                    Log::error('Ha fallado el envio de notificaciones push al usuario '.$user->email);
                }


            }
        }
        return 'Ok';

    }
}
