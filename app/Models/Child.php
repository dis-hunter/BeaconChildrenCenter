<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'children';

    // Fields that are mass assignable
    protected $fillable = [
        'registration_number',
        'fullname',  // JSON field for the child's full name
        'gender_id',
        'parent_id', // Assuming a parent-child relationship
        // Add other attributes as needed
    ];

    /**
     * Accessor for the `fullname` attribute (stored as JSON in the database).
     *
     * @param string $value
     * @return array|null
     */
    public function getFullnameAttribute($value)
    {
        return json_decode($value, true); // Decode JSON to an associative array
    }

    /**
     * Define the relationship to the `Parent` model.
     */
    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id'); // Adjust the foreign key if needed
    }

    /**
     * Define the relationship to the `Gender` model.
     */
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id'); // Adjust the foreign key if needed
    }

    /**
     * Define the relationship to the `Triage` model.
     */
    public function triage()
    {
        return $this->hasOne(Triage::class, 'child_id'); // Adjust the foreign key if needed
    }

    /**
     * Define the relationship to the `Invoice` model.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'child_id'); // Adjust the foreign key if needed
    }
}
