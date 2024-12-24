<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class children extends Model
{
    use HasFactory;
    protected $table = 'children';
    // Define fillable attributes
    protected $fillable = [
        'fullname',
        'dob',
        'birth_cert',
        'gender_id',
        'registration_number',
        'parent_id',
        
    ];

    // Automatically handle JSON serialization for 'fullname'
    protected $casts = [
        'fullname' => 'array',
    ];

    // Define primary key behavior
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Optional: Accessor and mutator for 'fullname' if needed
    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value),
        );
    }
}
