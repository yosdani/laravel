<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    protected $table = 'table_matricula';

    protected $fillable = [ 'name' ];
}
