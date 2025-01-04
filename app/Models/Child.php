<?php

// app/Models/Child.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $table = 'children';

    protected $fillable = [
        'registration_number',
        'fullname',  // JSON field for child's full name
        'gender_id',
        // other attributes...
    ];

    // Relationship to the Parent model
    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id'); // Adjust the foreign key if needed
    }

    // Accessor for fullname (stored as JSON)
    public function getFullnameAttribute($value)
    {
        return json_decode($value, true);  // Decode JSON to array
    }
}

