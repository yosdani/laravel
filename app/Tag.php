<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
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

    public function incidences(): BelongsTo
    {
        return $this->belongsTo(Incidence::class);
    }
    /**
     * Get tags
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @return Collection
     */
    public static function allTags( $dateInit, $dateEnd){
        return Tag::select('tags.id')
                    ->where('tags.created_at','>=',$dateInit)
                    ->where('tags.created_at','<=',$dateEnd)
                    ->get();
    }
}
