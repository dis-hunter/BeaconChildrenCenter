<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // If you're using timestamps
    public $timestamps = true;

    // If you're using a custom table name
    protected $table = 'payments';

    // If you want to protect certain columns from mass assignment
    protected $fillable = ['amount', 'child_id', 'payment_mode_id', 'staff_id', 'payment_date', 'created_at', 'updated_at'];

    // Define the relationships or any other methods if needed
}
