<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $table = 'street';

    protected $fillable = [
        'street', 'number'
    ];
}
