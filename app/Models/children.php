<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kayandra\Hashidable\Hashidable;
use Laravel\Scout\Searchable;

class children extends Model
{
    use HasFactory;
    use Searchable;
    use Hashidable;

    protected $table = 'children';
    // Define fillable attributes
    protected $fillable = [
        'fullname',
        'dob',
        'birth_cert',
        'gender_id',
        'registration_number',        
    ];

    // Automatically handle JSON serialization for 'fullname'
    protected $casts = [
        'fullname' => 'array',
    ];

    public function toSearchableArray()
    {
    $fullname = $this->fullname
        ? trim(($this->fullname->first_name ?? '') .' '.($this->fullname->middle_name ?? ''). ' ' . ($this->fullname->last_name ?? ''))
        : '';
        return [
            'id'=>$this->id,
            'fullname'=>$fullname,
            'birth_cert' => $this->birth_cert,
            'dob' => $this->dob,
            'registration_number'=>$this->registration_number
        ];
    }

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

    public function parents()
{
    return $this->hasManyThrough(Parents::class, ChildParent::class, 'child_id', 'id', 'id', 'parent_id');
}
}
