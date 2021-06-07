<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    protected $table = 'enrolment';

    protected $fillable = [ 'name' ];
}
