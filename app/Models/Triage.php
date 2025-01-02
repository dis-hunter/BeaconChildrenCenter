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
        'data',  'temperature',
        'respiratory_rate',
        'pulse_rate',
        'blood_pressure',
        'weight',
        'height',
        'muac',
        'head_circumference',
    ];

    // Define the inverse relationship to the Child model
    public function child()
    {
        return $this->belongsTo(children::class);
    }

    // Accessor for data (assuming it's stored as JSON)
    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}