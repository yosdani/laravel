<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function userWorker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_role');
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
     * @return array
     * 
     */
    public static function information(){
        return Area::select('area.*')->orderBy('created_at','asc')->get();
    }

    /**
     * Get names of areas
     * @return array
     * 
     */
    public static function names(){
        return Area::select('area.name')->orderBy('created_at','asc')->get();
    }
}
