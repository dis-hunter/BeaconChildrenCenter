<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Triage extends Model
{
    use HasFactory;
    protected $table = 'triage';

    protected $fillable = [
        'child_id',
        'data', // This will store the JSON data
        // ... other attributes ...
    ];

    // Define the inverse relationship to the Child model
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    // Accessor for data (assuming it's stored as JSON)
    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}