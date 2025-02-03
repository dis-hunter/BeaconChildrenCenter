<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriageAssessment extends Model
{
    use HasFactory;

    protected $table = 'triage_assessment';

    protected $fillable = [
        'assessment',
    ];
}
