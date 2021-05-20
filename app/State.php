<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected  $fillable = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function incidence() {
        return $this->hasOne(\App\Incidence::class );
    }
}
