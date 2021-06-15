<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{/**
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
        'title','subTitle','content'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function images()
    {
        return $this->hasMany(NoticeImage::class, 'news_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(News::class, 'category_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(News::class, 'user_id');
    }

    /**
     * Get news by user id
     * @return Collection
     *
     */
    public function newsByUserId($id)
    {
        return $this->select('news.*')
            ->where('news.user_id', $id);
    }
}