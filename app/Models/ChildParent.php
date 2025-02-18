<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildParent extends Model
{
    use HasFactory;

    protected $table='child_parent';
    
    protected $fillable = [
        'parent_id',
        'child_id'
    ];
}
