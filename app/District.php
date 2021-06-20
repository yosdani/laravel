<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class District extends Model
{
    protected $table = 'district';

    protected $fillable = [ 'district' ];


    /**
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function incidence()
    {
        return $this->hasMany(\App\Incidence::class);
    }

    /**
     * Get all names of distinct
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @return Collection
     * 
     */
    public static function names( $dateInit, $dateEnd ){
        return District::select('district.district')
                        ->where('district.created_at','>=',$dateInit)
                        ->where('district.created_at','<=',$dateEnd)
                        ->orderBy('created_at','asc')
                        ->get();
    }

    /**
     * Get all information of district
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @return Collection
     * 
     */
    public static function information( $dateInit, $dateEnd ){
        return District::select('district.*')
                        ->where('district.created_at','>=',$dateInit)
                        ->where('district.created_at','<=',$dateEnd)
                        ->orderBy('created_at','asc')
                        ->get();
    }
}
