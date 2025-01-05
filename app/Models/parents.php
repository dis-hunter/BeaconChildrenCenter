<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Parents extends Model
{
    use HasFactory;
    use Searchable;

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

    public function toSearchableArray()
    {
        // Decode JSON 'fullname' and construct a single string
    $fullnameData = json_decode($this->fullname, true);
    $fullname = $fullnameData
        ? trim(($fullnameData['firstname'] ?? '') . ' ' . ($fullnameData['lastname'] ?? ''))
        : '';
        return [
            'id'=>$this->id,
            'fullname'=>$fullname,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'national_id'=>$this->national_id
        ];
    }

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
    return $this->hasManyThrough(children::class, ChildParent::class, 'parent_id', 'id', 'id', 'child_id');
}


    // Accessor for fullname (assuming it's stored as JSON)
    public function getFullnameAttribute($value)
    {
        return json_decode($value);
    }
}
