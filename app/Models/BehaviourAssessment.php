<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BehaviourAssessment extends Model
{
    use HasFactory;

    protected $table = 'behaviour_assessment';

    protected $fillable = [
        'visit_id',
        'child_id',
        'doctor_id',
        'data',
    ];
}
