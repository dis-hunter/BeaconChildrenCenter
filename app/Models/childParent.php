<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class childParent extends Model
{
    use HasFactory;

    public function childParent()
{
    return $this->belongsTo(ChildParent::class, 'child_id', 'child_id');
}
}
