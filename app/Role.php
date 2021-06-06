<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [ 'name' ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'role_user');
    }
}
