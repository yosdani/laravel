<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    protected $table = 'table_roles';

    protected $fillable = [ 'name' ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'table_role_user');
    }
}
