<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsImage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news_image';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'image', 'news_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}
