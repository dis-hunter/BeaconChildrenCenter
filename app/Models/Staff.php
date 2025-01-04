<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['fullname', 'telephone', 'email', 'email_verified','password','staff_no','remember_token','role_id','specialization_id','gender_id'];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'staff_id', 'id');
    }
}