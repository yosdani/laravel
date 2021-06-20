<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tags extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get tags 
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @return Collection
     */
    public static function allTags( $dateInit, $dateEnd){
        return Tags::select('tags.id')
                    ->where('tags.created_at','>=',$dateInit)
                    ->where('tags.created_at','<=',$dateEnd)
                    ->get();
    }
}
