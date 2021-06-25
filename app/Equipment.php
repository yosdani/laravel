<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    protected $table = 'equipments';

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
    public function incidences(): HasMany
    {
        return $this->hasMany(Incidence::class, 'equipment_id');
    }

}
