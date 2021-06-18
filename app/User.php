<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Area;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastName', 'email', 'phoneNumber', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
    * Get the identifier that will be stored in the subject claim of the JWT.
    *
    * @return mixed
    */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function userRole(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function workerArea(): BelongsToMany
    {
        return $this->belongsToMany(Area::class, 'worker_area');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  HasOne
     */

    public function area(): HasOne
    {
        return $this->hasOne(Area::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  HasMany
     */
    public function incidence()
    {
        return $this->hasMany(Incidence::class, 'user_id');
    }

    public function userCategory():BelongsToMany
    {
        return $this->belongsToMany(Category::class,'user_categories');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return  HasMany
     */
    public function news()
    {
        return $this->hasMany(News::class, 'user_id');
    }

    /**  Get users by rol responsable
     * @return Collection
     *
     */
    public static function responsables()
    {
        return User::select('users.*')
                    ->leftjoin('role_user','users.id','=','role_user.user_id')
                    ->where('role_user.role_id','=',2)
                    ->get();
    }

    /**  Get users rol responsable by area
     * @param int $area
     * @return Collection
     *
     */
    public static function responsableByArea($area)
    {
        return User::select('users.*')
                    ->leftjoin('area','area.user_id','=','users.id')
                    ->leftjoin('role_user','users.id','=','role_user.user_id')
                    ->where('role_user.role_id','=',2)
                    ->where('area.id',$area)
                    ->get();
    }

    /**  Get users by rol worker
     * @return Collection
     *
     */
    public static function workers()
    {
        return User::select('users.*')
                    ->leftjoin('role_user','users.id','=','role_user.user_id')
                    ->where('role_user.role_id','=',3)
                    ->get();
    }

    /**
     * 
     * 
     */
    public static function workerWithArea(){
        return WorkerArea::select('worker_area.user_id')->get();
    }

    public static function workerWithoutArea(){
        $list_workers = User::workers();

        $workers_area = User::workerWithArea();
        
        foreach($workers_area as $worker){
            foreach ($list_workers as $key => $list){
                if($worker->user_id == $list->id){
                    unset($list_workers[$key]);
                }
            }
        }

        return $list_workers;
    }

    public function name()
    {
        return $this->name;
    }
    public function lastName()
    {
        return $this->lastName;
    }
    public function email()
    {
        return $this->email;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get workers by area
     * @param int $idArea
     * @return array
     * 
     */
    public static function workersByArea($idArea)
    {
        return User::select('users.name')
                    ->leftjoin('role_user','users.id','=','role_user.user_id')
                    ->leftjoin('worker_area','worker_area.user_id','=','users.id')
                    ->where('role_user.role_id','=',3)
                    ->where('worker_area.area_id',$idArea)
                    ->with('incidence')
                    ->get();
    }
}
