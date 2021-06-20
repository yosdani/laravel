<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Incidence extends Model
{
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
        'title','assignedTo','reviewer','deadLine','tags','description','attachedContent',
        'dni','applicant','phone','centerEnrollment','streetNumber','district','neighborhood','address',
        'team','location','responseForCitizen'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Incidence::class, 'user_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(Incidence::class, 'state_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(IncidenceImage::class, 'incidence_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enrolment()
    {
        return $this->belongsTo(\App\Enrolment::class, 'enrolment_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publicCenter()
    {
        return $this->belongsTo(\App\PublicCenter::class, 'public_center_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function breakdown()
    {
        return $this->belongsTo(\App\Incidence::class, 'breakdown_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function district()
    {
        return $this->belongsTo(\App\District::class, 'district');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function street()
    {
        return $this->belongsTo(\App\Street::class, 'streetNumber');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function neighborhood()
    {
        return $this->belongsTo(\App\Neighborhood::class, 'neighborhood');
    }

    /**
     * Get incidences by user id
     * @return Collection
     *
     */
    public function incidencesByUserId($id)
    {
        return $this->select('incidence.*')
                    ->where('incidence.user_id', $id);
    }

    /**
     * Get incidences by worker id
     * @return Collection
     *
     */
    public function incidencesByWorkerId($id)
    {
        return $this->select('incidence.*')
                    ->where('incidence.assignedTo', $id);
    }

    /**
     * Get incidences total
     * @param int $idResponsable
     * @return array
     */
    public static function incidencesTotalByArea($idResponsable, $dateInit, $dateEnd){
        return Incidence::select('incidence.id')
                        ->where('incidence.reviewer',$idResponsable)
                        ->where('incidence.created_at','>=',$dateInit)
                        ->where('incidence.created_at','<=',$dateEnd)
                        ->get()
                        ->count();
    }

    /**
     * Get all incidences finished
     * @param int $idResponsable
     * @param int $idState
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @param array $tags
     * @return array
     * 
     */
    public static function stateActual($idResponsable, $idState, $dateInit, $dateEnd, $tags){
        return Incidence::select('incidence.id')
                        ->where('incidence.reviewer',$idResponsable)
                        ->where('incidence.state_id',$idState)
                        ->where('incidence.created_at','>=',$dateInit)
                        ->where('incidence.created_at','<=',$dateEnd)
                        ->whereIn('incidence.tags',$tags)
                        ->get()
                        ->count();
    }

    /**
     * Get incidence by district
     * @param int $idDistrict
     * @return array
     * 
     */
    public static function getIncidenceByDistrict($idDistrict)
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
                        ->whereIn('incidence.tags',$tags)
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
}
