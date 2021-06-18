<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     * @return array
     * 
     */
    public static function names(){
        return District::select('district.district')->orderBy('created_at','asc')->get();
    }

    /**
     * Get all information of district
     * @return array
     * 
     */
    public static function information(){
        return District::select('district.*')->orderBy('created_at','asc')->get();
    }
}
