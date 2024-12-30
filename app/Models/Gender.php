<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;
    protected $table = 'gender';

    public function parent()
    {
        return $this->hasOne(Parents::class);
    }
    public function children()
    {
        return $this->hasOne(children::class);
    }
    public function staff()
    {
        return $this->hasOne(User::class);//describes Staff table
    }

}
