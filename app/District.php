<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';

    protected $fillable = [ 'district' ];


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
