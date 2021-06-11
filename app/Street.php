<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $table = 'street';

    protected $fillable = [
        'street', 'number'
    ];

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
