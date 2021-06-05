<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Incidence;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [ 'name' ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Incidence(): BelongsTo
    {
        return $this->belongsTo(User::class, 'role_user');
    }
}

