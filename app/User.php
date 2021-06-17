<?php

namespace App;

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
    public function responsables()
    {
        return $this->select('users.*')
                    ->leftjoin('role_user','users.id','=','role_user.user_id')
                    ->where('role_user.role_id','=',2)
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

    public static function workerWithoutArea(){
        $workerWithArea = User::select('users.*')
                            ->leftjoin('role_user','users.id','=','role_user.user_id')
                            ->leftjoin('worker_area','worker_area.user_id','=','users.id')
                            ->where('role_user.role_id','=',3)
                            ->with('workerArea')
                            ->get();
        $workersWithoutArea = [];

            foreach ($workerWithArea as $area){
                if(!isset($area->worker_area))
                    $workersWithoutArea[] = $area;
            }

        return $workersWithoutArea;       
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
}
