<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // Explicitly set the table name
    protected $table = 'doctors';

    // Enable timestamps as the table includes created_at/updated_at
    public $timestamps = true;

    // Define the fillable columns
    protected $fillable = ['staff_id', 'specialization_id'];

    /**
     * Relationship: Each doctor belongs to one staff member
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    /**
     * Relationship: Each doctor belongs to one specialization
     */
    public function specialization()
    {
        return $this->belongsTo(DoctorSpecialization::class, 'specialization_id', 'id');
    }
}
