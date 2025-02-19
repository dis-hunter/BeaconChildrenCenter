<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses'; // Explicitly define table name (optional)

    protected $fillable = [
        'category',
        'description',
        'fullname',
        'amount',
        'payment_method',
        'staff_id',
    ];

    /**
     * Relationship: An expense belongs to a staff member.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
