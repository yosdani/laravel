<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class State extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var string
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return  HasMany
     */
    public function incidence()
    {
        return $this->hasMany(Incidence::class, 'state_id');
    }

    /**
     * Get states
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @return Collection
     * 
     * 
     */
    public static function allStates($dateInit, $dateEnd){
        return State::select('states.id')
                    ->where('states.created_at','>=',$dateInit)
                    ->where('states.created_at','<=',$dateEnd)
                    ->get();
    }
}
