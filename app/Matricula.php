<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'table_matricula';

    protected $fillable = [ 'name' ];
}
