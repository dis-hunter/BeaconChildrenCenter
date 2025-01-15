<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table='staff';

<<<<<<< HEAD
    public function specialization()
=======
    protected $fillable = ['fullname', 'telephone', 'email', 'email_verified', 'password', 'staff_no', 'remember_token', 'role_id', 'specialization_id', 'gender_id'];

<<<<<<< HEAD
    public function doctors()
>>>>>>> 4ffaa8539790faf3134ff89a602e71fb7eeac372
    {
        return $this->belongsTo(DoctorSpecialization::class, 'specialization_id');
    }
<<<<<<< HEAD

    protected $fillable = [
        'fullname', 'telephone', 'email', 'email_verified_at', 'password', 'staff_no', 'remember_token', 'gender_id', 'role_id', 'specialization_id'
    ];
=======
>>>>>>> 4ffaa8539790faf3134ff89a602e71fb7eeac372
=======
>>>>>>> d72161ed07d123d1b0a77e9b4afff990f86026b0
}
