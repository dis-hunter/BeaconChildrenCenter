<?php

namespace App\Models;

use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    //use SoftDeletes, HasRoles;

    protected $table = 'staff';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    

    protected $fillable = [
        'fullname',
        'email',
        'password',
        'telephone',
        'staff_no',
        'gender_id',
        'role_id',
        'specialization_id',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_admin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fullname' => 'array',
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean'
    ];

   // Accessor for fullname (assuming it's stored as JSON)
   public function getFullnameAttribute($value)
   {
       return json_decode($value);
   }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function gender(){
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class); 
    }

    public function activeSession(){
        return $this->hasOne(ActiveUser::class,'staff_id');
    }

    public static function getActiveUsers($minutes=5){
        return self::whereHas('activeSession', function ($query) use ($minutes){
            $query->where('last_activity', '>=', Carbon::now()->subMinutes($minutes));
        })
        ->with('activeSession')
        ->get();
    }
}