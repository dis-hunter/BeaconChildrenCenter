<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Careplan extends Model
{
    use HasFactory;

    protected $table = 'careplan';

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }

    public static function notes($careplan)
    {
        $data = is_string($careplan->data) ? json_decode($careplan->data, true) : (array)$careplan->data;
        return array_filter($data, function ($value, $key) {
            return str_contains($key, 'Notes') && !is_null($value);
        }, ARRAY_FILTER_USE_BOTH);
    }
}
