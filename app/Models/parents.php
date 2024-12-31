<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    protected $table='parents';

    // Define fillable attributes
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
        'relationship_id',
    ];

    // Automatically handle JSON serialization for 'fullname'
    protected $casts = [
        'fullname' => 'array',
    ];

    // Define primary key behavior
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    public function relationship(){
        return $this->belongsTo(Relationship::class,'relationship_id','id');
    }
    
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    
    public function children()
    {
        return $this->belongsToMany(children::class,'child_parent','parent_id','child_id');
    }

    // Accessor for fullname (assuming it's stored as JSON)
    public function getFullnameAttribute($value)
    {
        return json_decode($value);
    }
}
