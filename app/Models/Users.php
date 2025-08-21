<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Users extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $table = 'customer';
    protected $primaryKey = 'cust_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'country',
        'ip',
        'refferal_id',
        'from_refferal_id',
        'person_id',
        'profile',
        'balance',
        'reason',
        'p_token',
        'token',
        'status',
        'type',
        'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'ip',
        'token',
        'p_token',
        'type',
        'banned_time',
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }    

    public static function UserName($id)
    {
            if($user =Users::where('cust_id', $id)->exists()){
                 return Users::where('cust_id', $id)->get()->first()->name;   
            }else{
                return null;
            }
        
    }

    public static function LastLogin($id)
    {
        return Users::where('cust_id', $id)->get()->first()->name;
    }
}