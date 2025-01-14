<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'staff';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'telephone',
        'staff_no',
        'password',
        'gender_id',
        'role_id',
        'specialization_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fullname'=> 'array',
        'email_verified_at' => 'datetime',
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
        })->with('activeSession')->get();
    }
}
