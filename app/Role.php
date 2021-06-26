<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [ 'name' ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
