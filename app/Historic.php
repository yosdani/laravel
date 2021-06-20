<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Historic extends Model
{
    protected $table = 'historic';

    public function incidence(): BelongsTo
    {
        return $this->belongsTo(Incidence::class, 'incidence_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
