<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow_Up extends Model
{
    use HasFactory;
    protected $table= 'follow_up';

    protected $casts = [
        'data'=>'array',
    ];

    public function getDataAttribute($value){
        return json_decode($value);
    }
}
