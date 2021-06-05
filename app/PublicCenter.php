<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicCenter extends Model
{
    protected $table = 'public_center';

    protected $fillable = [ 'name' ];
}

