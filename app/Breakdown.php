<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breakdown extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'breakdown';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  HasMany
     */

    public function incidence()
    {
        return $this->hasMany(Incidence::class, 'breakdown_id');
    }
}
