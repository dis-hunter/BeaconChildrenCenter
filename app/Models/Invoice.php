<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table='invoices';

    protected $fillable =[
        'child_id',
        'total_amount',
        'invoice_details',
        'invoice_date',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'invoice_details' => 'json',
        'total_amount' => 'decimal:2'
    ];

    public function getInvoiceDetailsAttribute($value){
        return json_decode($value);
    }
    

    public function visit()
    {
        return $this->belongsTo(Visits::class);
    }
}
