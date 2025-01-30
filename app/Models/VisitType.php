<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitType extends Model
{
    use HasFactory;

    protected $table='visit_type';

    protected $fillable = [
        'visit_type',
        'sponsored_price',
        'normal_price',
    ];

    protected $casts = [
        'normal_price'=>'float',
        'sponsored_price'=>'float',
    ];
}
