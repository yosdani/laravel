<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    const IMAGE_PATH = 'public/images/news/';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'title','subtitle','content'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(NewsImage::class, 'news_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
