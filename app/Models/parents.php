<?php

// app/Models/Parents.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'fullname', // JSON field for parent's full name
        'dob',
        'gender_id',
        'telephone',
        'email',
        'national_id',
        'employer',
        'insurance',
        'referer',
        'relationship_id',
    ];

    // Automatically handle JSON serialization for 'fullname'
    protected $casts = [
        'fullname' => 'array',  // Cast 'fullname' as array for easier access
    ];

    // Accessor for fullname if needed
    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),  // Decode the JSON field
            set: fn($value) => json_encode($value),  // Encode back if needed
        );
    }
}

