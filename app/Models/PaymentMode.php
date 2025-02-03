<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PaymentMode extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public const NCPWD_ID = 3;

    public function visits()
    {
        return $this->hasMany(Visits::class);
    }
}


