<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Diagnosis extends Model
{
    use HasFactory;
    protected $table='diagnosis';

    // Defining fillable attributes
    protected $fillable = [
        'visit_id',
        'child_id',
        'doctor_id',
        'data',
    ];

    // Ensure Eloquent assumes an auto-incrementing primary key named 'id'
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Accessor and Mutator for 'data' attribute
    protected function data(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value),
        );
    }
}
