<?php

namespace App\Observers;
use App\Incidence;
use App\Mail\IncidenceMails;
use App\Notifications\IncidenceCreatedNotification;
use App\Notifications\IncidenceEditedNotification;
use App\State;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class IncidenceObserver
{
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
        $incidence->notify(new IncidenceCreatedNotification($this->user));

    }

    /**
     * Handle the Incidence "updated" event.
     *
     * @param Incidence $incidence
     * @return void
     */
    public function updated(Incidence $incidence)
    {
        $incidence->notify(new IncidenceEditedNotification($this->user));
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
}
