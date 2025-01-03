<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    // Define fillable attributes
    protected $fillable = [
        'child_id',
        'doctor_id',
        'staff_id',
        'appointment_date',
        'status',
        'created_at',
        'updated_at',
        'start_time',
        'end_time',
        'appointment_title'
    ];

    // Define primary key behavior
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Relationships

    /**
     * Define the relationship with the `children` table.
     */
    public function child()
    {
        return $this->belongsTo(Children::class, 'id');
    }

    /**
     * Define the relationship with the `staff` table for the doctor.
     */
    public function doctor()
    {
        return $this->belongsTo(Staff::class, 'id');
    }

    /**
     * Define the relationship with the `staff` table for the staff member.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'id');
    }
}
