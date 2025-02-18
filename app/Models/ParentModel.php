<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    public function parent()
{
    return $this->belongsTo(ParentModel::class, 'parent_id', 'id');
}

}
