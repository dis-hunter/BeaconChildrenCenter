<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // Explicitly set the table name
    protected $table = 'doctors'; 
    // Disable Laravel's automatic timestamps if your table doesn't have created_at/updated_at
    public $timestamps = true; 

    // Define the fillable columns that are mass assignable
    protected $fillable = ['staff_id', 'specialization'];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}