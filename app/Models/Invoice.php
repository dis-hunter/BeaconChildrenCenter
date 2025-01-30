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
        'invoice_status'
    ];

    protected $casts = [
        'invoice_details' => 'array',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }

    public function getInvoiceDetailsAttribute($value){
        return json_decode($value);
    }
}
