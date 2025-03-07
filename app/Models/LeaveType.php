<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type');
    }

    public function staffLeaves()
    {
        return $this->hasMany(StaffLeave::class, 'leave_type');
    }
}
