<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class userRoles extends Model
{
    protected $table = 'table_roles';

    protected $fillable = [ 'name' ];

    public function User(){
        return $this->belongsTo( User::class, 'table_role_user' );
    }
}
