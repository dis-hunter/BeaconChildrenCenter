<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSpecialization extends Model
{
    use HasFactory;

    // Define the table name explicitly
    protected $table = 'doctor_specialization';
    protected $fillable = ['id', 'specialization'];

  
    

    // Disable timestamps if your table doesn't use them
    public $timestamps = false;
}
