<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidenceImage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'incidence_image';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'image','idIncidence',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function incidence()
    {
        return $this->belongsTo(\App\Incidence::class, 'idIncidence', 'id');
    }
}
