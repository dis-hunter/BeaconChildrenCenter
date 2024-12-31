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

    // Define the relationship to the Gender model
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }


    // Define the relationship to the Triage model
    public function triage()
    {
        return $this->hasOne(Triage::class);
    }

    // Accessor for fullname (assuming it's stored as JSON)
    public function getFullnameAttribute($value)
    {
        return json_decode($value);
    }

    public function parent(){
        return $this->belongsToMany(Parents::class,'child_parent','child_id','parent_id');
    }
}
