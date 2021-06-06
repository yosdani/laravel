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
        return $this->belongsTo(\App\User::class, 'responsable', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state():BelongsTo
    {
        return $this->belongsTo(\App\State::class, 'idState', 'id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(IncidenceImage::class, 'idIncidence');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function matricula():BelongsTo
    {
        return $this->belongsTo(\App\Enrolment::class, 'idMatricula', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publicCenter():BelongsTo
    {
        return $this->belongsTo(\App\PublicCenter::class, 'idPublicCenter', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function breakdown():BelongsTo
    {
        return $this->belongsTo(\App\Breakdown::class, 'idBreakdown', 'id');
    }
}
