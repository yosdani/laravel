<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    protected $table = 'neighborhood';

    protected $fillable = [ 'name' ];

    /**
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function incidence()
    {
        return $this->hasMany(\App\Incidence::class);
    }
}
