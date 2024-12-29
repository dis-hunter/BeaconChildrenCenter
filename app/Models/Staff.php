<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = ['fullname', 'telephone', 'email', 'gender_id', 'role_id'];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'staff_id', 'id');
    }
}