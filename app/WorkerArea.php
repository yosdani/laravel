<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerArea extends Model
{
    protected $table = 'worker_area';

    protected $fillable = [ 'user_id', 'area_id' ];
}
