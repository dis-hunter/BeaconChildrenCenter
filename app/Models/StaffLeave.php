<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class StaffLeave extends Model
{
    use HasFactory;
    protected $table = 'staff_leave';

    protected $fillable = ['staff_id', 'start_date', 'end_date', 'reason', 'leave_type_id', 'status'];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
    

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function leaveType()
{
    return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
}

}

