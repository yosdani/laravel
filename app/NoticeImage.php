<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoticeImage extends Model
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
        'image','urlImage','news_id'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function news()
    {
        return $this->belongsTo(NoticeImage::class, 'news_id');
    }
}
