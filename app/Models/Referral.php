<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $casts=[
        'data'=>'array',
    ];
    public function getDataAttribute($value){
        return json_decode($value);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

}
