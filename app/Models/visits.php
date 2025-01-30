<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visits extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'visits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'child_id',
        'visit_type',
        'visit_date',
        'source_type',
        'source_contact',
        'staff_id',
        'doctor_id',
        'appointment_id',
        'triage_pass',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'triage_pass' => 'boolean',
        'completed' => 'boolean',
        'triage_pass' => 'boolean',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function visitType()
    {
        return $this->belongsTo(VisitType::class, 'visit_type');
    }
    public function paymentMode(): BelongsTo
    {
        return $this->belongsTo(PaymentMode::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
