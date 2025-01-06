<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table='staff';

    public function specialization()
    {
        return $this->belongsTo(DoctorSpecialization::class, 'specialization_id');
    }

    protected $fillable = [
        'fullname', 'telephone', 'email', 'email_verified_at', 'password', 'staff_no', 'remember_token', 'gender_id', 'role_id', 'specialization_id'
    ];
}
