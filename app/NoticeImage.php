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
    protected $table = 'notice_image';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'image','urlImage','idNotice'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notice()
    {
        return $this->belongsTo(NoticeImage::class,'idNotice');

    }
}
