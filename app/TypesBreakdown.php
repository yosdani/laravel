<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypesBreakdown extends Model
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


}
