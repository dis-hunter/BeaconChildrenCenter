<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class parents extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullname',
        'dob',
        'gender_id',
        'telephone',
        'email',
        'national_id',
        'employer',
        'insurance',
        'referer',
        'relationship_id'
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
