<?php

namespace App\Models;

use App\Http\Responses\LoginResponse;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use function PHPUnit\Framework\returnSelf;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table='staff';

    protected $fillable = [
        'fullname',
        'email',
        'password',
        'telephone',
        'staff_no',
        'gender_id',
        'role_id',
        'specialization_id',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fullname' => 'array',
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getFullnameAttribute($value){
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

    protected function defaultProfilePhotoUrl()
    {
        $fullname = $this->fullname;
        $initials = collect([
            mb_substr($fullname->first_name ?? '', 0, 1),
            mb_substr($fullname->last_name ?? '', 0, 1)
        ])->filter()->join(' ');

        return 'https://ui-avatars.com/api/?name='.urlencode($initials).'&color=FFFFFF&background=000000';
    }
    
    public function getDashboardRoute(){
        return match($this->role_id){
            1 => 'triage.dashboard',
            2 => 'doctor.dashboard',
            3 => 'reception.dashboard',
            5 => $this->getTherapistRoute($this->specialization_id), // Calls therapist function
            default => RouteServiceProvider::HOME,
        };
    }
    
    public function getTherapistRoute($specialization_id){
        return match($specialization_id){
            default => 'therapistsDashboard', // Now redirects therapists to this route
        };
    }
    
}