<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'fullname', 
        'telephone', 
        'email', 
        'email_verified', 
        'password', 
        'staff_no', 
        'remember_token', 
        'role_id', 
        'specialization_id', 
        'gender_id'
    ];
    public function getFilamentName(): string
{
    return $this->fullname ;
}


    /**
     * Define the relationship with DoctorSpecialization.
     */
    public function doctors()
    {
        return $this->belongsTo(DoctorSpecialization::class, 'specialization_id');
    }
}
