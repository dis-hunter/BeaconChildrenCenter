<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices'; // Specify table name if not the plural of the model name

    protected $fillable = [
        'child_id',
        'total_amount',
        'invoice_details',
        'invoice_date',
    ];

    // Relationship to the Child model
    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }

    // Static helper method to fetch invoice dates for a child
    public static function getInvoicesByChild($childId)
{
    try {
        $dates = self::where('child_id', $childId)
            ->orderBy('invoice_date', 'desc')
            ->pluck('invoice_date');
            
        // Convert dates to string format
        return $dates->map(function($date) {
            // Handle null dates
            if (!$date) return null;
            
            // If it's already a string, parse it first
            if (is_string($date)) {
                return date('Y-m-d', strtotime($date));
            }
            
            // If it's a Carbon instance
            return $date->format('Y-m-d');
        })->filter(); // Remove any null values
    } catch (\Exception $e) {
        \Log::error('Error in getInvoicesByChild: ' . $e->getMessage());
        return collect([]); // Return empty collection on error
    }
}
}
