<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'area';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'name','user_id',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userWorker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_role');
    }

    public function workers()
    {
        return $this->belongsToMany(User::class, 'worker_area');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  HasMany
     */
    public function incidences(): HasMany
    {
        return $this->hasMany(Incidence::class, 'area_id');
    }
    /**
     * Get areas by rol
     * @param int $id
     * @return Collection
     *
     *
     */
    public function getByUserId($id)
    {
        return $this->select('area.*')
                    ->where('area.user_id',$id)
                    ->get();
    }

    /**
     * Get all information of areas
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @return array
     *
     */
    public static function information( $dateInit, $dateEnd){
        return Area::select('area.*')
                    ->where('area.created_at','>=',$dateInit)
                    ->where('area.created_at','<=',$dateEnd)
                    ->orderBy('created_at','asc')
                    ->get();
    }

    /**
     * Get names of areas
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @return array
     *
     */
    public static function names( $dateInit, $dateEnd){
        return Area::select('area.name')
                    ->where('created_at','>=',$dateInit)
                    ->where('created_at','<=',$dateEnd)
                    ->orderBy('created_at','asc')
                    ->get();
    }
}
