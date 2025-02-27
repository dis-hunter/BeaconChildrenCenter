<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSpecialization extends Model
{
    use HasFactory;
    protected $table = 'doctor_specialization';

    protected $fillable = ['specialization', 'role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
