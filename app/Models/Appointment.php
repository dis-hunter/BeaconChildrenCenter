<?php

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

    /**
     * Relationship to the Child model.
     */
    public function child()
    {
        return $this->belongsTo(child::class);
    }

    /**
     * Relationship to the Staff model.
     */
    public function staff()
    {
        return $this->belongsTo(staff::class);
    }
}
