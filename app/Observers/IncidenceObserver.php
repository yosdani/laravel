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

        $changes = $this->registerTittle($incidence, $changes);
        $changes = $this->registerState($incidence, $changes);
        $changes = $this->registerAssignedTo($incidence, $changes);
        $changes = $this->registerArea($incidence, $changes);
        $changes = $this->registerResponse($incidence, $changes);
        $changes = $this->registerDescription($incidence, $changes);
        $changes = $this->registerInternalResponse($incidence, $changes);

        $changes = $this->registerNeighborhood($incidence, $changes);
        $changes = $this->registerStreet($incidence, $changes);
        $changes = $this->registerDistrict($incidence, $changes);
        $changes = $this->registerPublicCenter($incidence, $changes);
        $changes = $this->registerEnrolment($incidence, $changes);

        $changes = $this->registerEquipment($incidence, $changes);
        $changes = $this->registerDeadLine($incidence, $changes);
        $changes = $this->registerDistrict($incidence, $changes);
        $changes = $this->registerPriority($incidence, $changes);

        try{
            $this->saveHistoric($incidence, $changes);
            $this->sendByPush(
                'Se ha midificado una incidencia',
                'La incidencia: '.$incidence->title.' se ha midificado',
                [
                    $incidence->user
                ]);
            $incidence->notify(new IncidenceEditedNotification($this->user, $changes));
            if($incidence->assignedTo){
                $incidence->notify(new IncidenceEditedNotification($incidence->assignedTo, $changes));
            }
        }catch (\Exception $exception){
            Log::error('Error enviando notificaciones '.$exception->getMessage());
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
        $historic->comment = $incidence->comment;
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

    /**
     * @param Incidence $incidence
     * @param $changes
     * @return mixed
     */
    private function registerInternalResponse(Incidence $incidence, $changes)
    {
        if ($incidence->wasChanged('internalResponse')) {
            $change = new EntityChanges(
                __('general.incidences.internalResponse'),
                $incidence->getOriginal('internalResponse'),
                $incidence->internalResponse
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
    private function registerNeighborhood(Incidence $incidence, $changes)
    {
        if ($incidence->wasChanged('neighborhood_id')) {
            $change = new EntityChanges(
                __('general.neighborhoods.neighborhood'),
                $incidence->getOriginal('neighborhood_id'),
                $incidence->neighborhood_id
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
    private function registerStreet(Incidence $incidence, $changes)
    {
        if ($incidence->wasChanged('street_id')) {
            $change = new EntityChanges(
                __('general.streets.street'),
                $incidence->getOriginal('street_id'),
                $incidence->street_id
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
    private function registerDistrict(Incidence $incidence, $changes)
    {
        if ($incidence->wasChanged('district_id')) {
            $change = new EntityChanges(
                __('general.districts.district'),
                $incidence->getOriginal('district_id'),
                $incidence->district_id
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
    private function registerPublicCenter(Incidence $incidence, $changes)
    {
        if ($incidence->wasChanged('public_center_id')) {
            $change = new EntityChanges(
                __('general.public_centers.public_center'),
                $incidence->getOriginal('public_center_id'),
                $incidence->public_center_id
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
    private function registerEnrolment(Incidence $incidence, $changes)
    {
        if ($incidence->wasChanged('enrolment_id')) {
            $change = new EntityChanges(
                __('general.enrolments.enrolment'),
                $incidence->getOriginal('enrolment_id'),
                $incidence->enrolment_id
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
    private function registerEquipment(Incidence $incidence, $changes)
    {
        if ($incidence->wasChanged('equipment_id')) {
            $change = new EntityChanges(
                __('general.equipments.equipment'),
                $incidence->getOriginal('equipment_id'),
                $incidence->equipment_id
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
    private function registerDeadLine(Incidence $incidence, $changes)
    {
        if ($incidence->wasChanged('deadline')) {
            $change = new EntityChanges(
                __('general.incidences.deadline'),
                $incidence->getOriginal('deadline'),
                $incidence->deadline ? $incidence->deadline->format('Y/m/d') : null
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
    private function registerPriority(Incidence $incidence, $changes)
    {
        if ($incidence->wasChanged('priority_id')) {
            $change = new EntityChanges(
                __('general.priorities.priority'),
                $incidence->getOriginal('priority_id'),
                $incidence->priority_id
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
                    Log::info('Respuesta de Firebase '.$response);
                    return $response;
                }catch(\Exception $exception){
                    Log::error('Ha fallado el envio de notificaciones push al usuario '.$user->email);
                }


            }
        }
        return 'Ok';

    }
}
