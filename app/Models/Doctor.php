<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    // Explicitly set the table name
    protected $table = 'doctors'; // Use the correct table name

    // Disable Laravel's automatic timestamps if your table doesn't have created_at/updated_at
    public $timestamps = true; // Set to false if your table does not have these columns

    // Define the fillable columns that are mass assignable
    protected $fillable = ['staff_id', 'specialization'];
}