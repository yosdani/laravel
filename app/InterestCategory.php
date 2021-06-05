<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestCategory extends Model
{
    protected $table = 'interest_category';

    protected $fillable = [ 'name' ];
}
