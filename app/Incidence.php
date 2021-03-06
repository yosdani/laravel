<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'title','assigned_id','deadLine','tag_id','description','attachedContent','applicant','centerEnrollment','streetNumber','district','neighborhood','address',
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
        return $this->belongsTo(User::class, 'assigned_id','id');
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id','id');
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
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(\App\Equipment::class, 'equipment_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function priority(): BelongsTo
    {
        return $this->belongsTo(\App\Priority::class, 'priority_id', 'id');
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
        return $this->belongsTo(\App\District::class, 'district_id');
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
        return $this->belongsTo(\App\Neighborhood::class, 'neighborhood_id');
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
     * @param int $idArea
     * @return array
     */
    public static function incidencesTotalByArea($idArea, $dateInit, $dateEnd){
        return Incidence::select('incidence.id')
                        ->where('incidence.area_id',$idArea)
                        ->where('incidence.created_at','>=',$dateInit)
                        ->where('incidence.created_at','<=',$dateEnd)
                        ->get()
                        ->count();
    }

    /**
     * Get all incidences finished
     * @param int $idArea
     * @param int $idState
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @param array $tags
     * @return array
     *
     */
    public static function stateActual($idArea, $idState, $dateInit, $dateEnd, $tags){
        return Incidence::select('incidence.id')
                        ->where('incidence.area_id',$idArea)
                        ->where('incidence.state_id',$idState)
                        ->where('incidence.created_at','>=',$dateInit)
                        ->where('incidence.created_at','<=',$dateEnd)
                        ->whereIn('tag_id',$tags)
                        ->get()
                        ->count();
    }

    /**
     * Get incidence by district
     * @param int $idDistrict
     * @return int
     *
     */
    public static function getIncidenceByDistrict(int $idDistrict): int
    {
        return Incidence::select('incidence.id')
                        ->where('incidence.district_id',$idDistrict)
                        ->get()
                        ->count();
    }


    /**
     * Get all incidences finished
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @return int
     *
     *
    */
    public static function finished( $dateInit, $dateEnd){
        return Incidence::select('incidence.*')
                        ->where('incidence.state_id',2)
                        ->where('incidence.created_at','>=',$dateInit)
                        ->where('incidence.created_at','<=',$dateEnd)
                        ->get()
                        ->count();
    }

    /**
     * Get incidences in progress
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @param array $tags
     * @return int
     *
     */
    public static function inProgress( $dateInit, $dateEnd, $tags){
        return Incidence::select('incidence.*')
                        ->where('incidence.state_id',1)
                        ->where('incidence.created_at','>=',$dateInit)
                        ->where('incidence.created_at','<=',$dateEnd)
                        ->whereIn('tag_id',$tags)
                        ->get()
                        ->count();
    }

    /**
     * Get incidences not assigned
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @return int
     *
     */
    public static function notAssigned( $dateInit, $dateEnd){
        return Incidence::select('incidence.*')
                        ->where('incidence.state_id',null)
                        ->where('incidence.created_at','>=',$dateInit)
                        ->where('incidence.created_at','<=',$dateEnd)
                        ->get()
                        ->count();
    }

    /**
     * Get all incidences
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @return int
     *
     */
    public static function allIncidence($dateInit, $dateEnd)
    {
        return Incidence::select('incidence.id')
                        ->where('incidence.created_at','>=',$dateInit)
                        ->where('incidence.created_at','<=',$dateEnd)
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
        return $notification->getUser()->email;

    }

}
