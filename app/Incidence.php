<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Incidence extends Model
{
    use Notifiable;

    const IMAGE_PATH = 'public/images/incidences/';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'incidence';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'title','assigned_id','reviewer','deadLine','tags','description','attachedContent','applicant','centerEnrollment','streetNumber','district','neighborhood','address',
        'team','location','responseForCitizen'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_role','id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(Incidence::class, 'state_id','id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function enrolment(): BelongsTo
    {
        return $this->belongsTo(\App\Enrolment::class, 'enrolment_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(IncidenceImage::class, 'incidence_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(\App\Area::class, 'area_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function publicCenter(): BelongsTo
    {
        return $this->belongsTo(\App\PublicCenter::class, 'public_center_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function breakdown(): BelongsTo
    {
        return $this->belongsTo(\App\Incidence::class, 'breakdown_id');
    }

    /**
     *
     * @return BelongsTo
     *
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(\App\District::class, 'district');
    }

    /**
     *
     * @return BelongsTo
     *
     */
    public function street(): BelongsTo
    {
        return $this->belongsTo(\App\Street::class, 'streetNumber');
    }

    /**
     *
     * @return BelongsTo
     *
     */
    public function neighborhood(): BelongsTo
    {
        return $this->belongsTo(\App\Neighborhood::class, 'neighborhood');
    }

    /**
     * Get incidences by user id
     * @param $id
     * @return Collection
     */
    public function incidencesByUserId($id): Collection
    {
        return $this->select('incidence.*')
                    ->where('incidence.user_id', $id);
    }

    /**
     * Get incidences by worker id
     * @param int $id
     * @return Collection
     */
    public function incidencesByWorkerId(int $id): Collection
    {
        return $this->select('incidence.*')
                    ->where('incidence.assigned_id', $id);
    }

    /**
     * Get incidences total
     * @param int $idResponsible
     * @return array
     */
    public static function incidencesTotalByArea(int $idResponsible): array
    {
        return Incidence::select('incidence.id')
                        ->where('incidence.reviewer',$idResponsible)
                        ->get()
                        ->count();
    }

    /**
     * Get all incidences finished
     * @param int $idResponsible
     * @param int $idState
     * @return array
     *
     */
    public static function stateActual(int $idResponsible, int $idState){
        return Incidence::select('incidence.id')
                        ->where('incidence.reviewer',$idResponsible)
                        ->where('incidence.state_id',$idState)
                        ->get()
                        ->count();
    }

    /**
     * Get incidence by district
     * @param int $idDistrict
     * @return array
     *
     */
    public static function getIncidenceByDistrict(int $idDistrict): array
    {
        return Incidence::select('incidence.id')
                        ->where('incidence.district_id',$idDistrict)
                        ->get()
                        ->count();
    }


    /**
     * Get all incidences finished
     * @return int
     *
     *
    */
    public static function finished(): int
    {
        return Incidence::select('incidence.*')
                        ->where('incidence.state_id',2)
                        ->get()
                        ->count();
    }

    /**
     * Get incidences in progress
     * @return int
     *
     */
    public static function inProgress(): int
    {
        return Incidence::select('incidence.*')
                        ->where('incidence.state_id',1)
                        ->get()
                        ->count();
    }

    /**
     * Get incidences not assigned
     * @return int
     *
     */
    public static function notAssigned(): int
    {
        return Incidence::select('incidence.*')
                        ->where('incidence.state_id',null)
                        ->get()
                        ->count();
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->user->email;

    }
}
