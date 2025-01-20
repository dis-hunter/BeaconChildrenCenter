<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;
    protected $table='relationships';

    protected $fillable = [
        'relationship',
    ];

    public function parent(){
        return $this->hasOne(Parents::class,'relationship_id','id');
    }
}
