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
        'name','assignedTo','reviewer','deadLine','creationDate','tags','description','attachedContent',
        'dni','applicant','phone','centerEnrollment','streetNumber','district','neighborhood','addressee',
        'team','location','responseForCitizen'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public  function user()
    {
        return $this->belongsTo(\App\User::class, 'responsable','id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public  function state()
    {
        return $this->belongsTo(\App\State::class, 'idState','id');
    }



}



