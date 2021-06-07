<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notice';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'name','texNotice'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function images()
    {
        return $this->hasMany(NoticeImage::class, 'notice_id');
    }
}
