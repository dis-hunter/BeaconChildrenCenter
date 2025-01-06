<?php
// app/Models/Appointment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_title',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'child_id',
        'staff_id',
        'doctor_id'
    ];


    // Relationship with the Child model
    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }

    // Relationship with the Parent model via Child
    public function parent()
    {
        return $this->child->parent();  // Assuming parent relationship on the Child model
    }
}
