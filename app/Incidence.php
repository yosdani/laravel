<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incidence extends Model
{
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
        'name','assignedTo','reviewer','deadLine','tags','description','attachedContent',
        'dni','applicant','phone','centerEnrollment','streetNumber','district','neighborhood','address',
        'team','location','responseForCitizen'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(\App\User::class, 'users_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state():BelongsTo
    {
        return $this->belongsTo(\App\State::class, 'states_id', 'id');
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
    public function enrolment():BelongsTo
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


}
