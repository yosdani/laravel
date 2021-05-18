<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userRoles extends Model
{
    protected $table = 'table_roles';

    protected $fillable = [ 'name' ];
}
