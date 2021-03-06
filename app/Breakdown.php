<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function incidence(): HasMany
    {
        return $this->hasMany(Incidence::class, 'breakdown_id');
    }
}
