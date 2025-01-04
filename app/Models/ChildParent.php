<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildParent extends Model
{
    use HasFactory;
    protected $table='child_parent';

    public function child(){
        return $this->belongsTo(children::class,'child_id');
    }
    
    public function parent(){
        return $this->belongsTo(Parents::class,'parent_id');
    }
}
