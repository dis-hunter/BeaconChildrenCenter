<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;  
    protected $table = 'children'; // Assuming the table name is 'children'

    protected $fillable = [
        'registration_number',
        'fullname', 
        'gender_id',
        // ... other attributes ...
    ];

    // Define the relationship to the Triage model
    public function triage()
    {
        return $this->hasOne(Triage::class);
    }

    // Define the relationship to the Gender model
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    // Accessor for fullname (assuming it's stored as JSON)
    public function getFullnameAttribute($value)
    {
        return json_decode($value);
    }
}