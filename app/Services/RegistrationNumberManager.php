<?php

namespace App\Services;

use Dotenv\Util\Str;
use Illuminate\Support\Facades\DB;

class RegistrationNumberManager
{
    protected $table;
    protected $field;

    public function __construct(string $table, string $field)
    {
        $this->table = $table;
        $this->field = $field;
    }

    /**
     * Generate a new unique registration number.
     *
     * @return string
     */
    public function generateUniqueRegNumber(): string
    {
        // Get the current year
        $year = date('Y');

        // Find the maximum registration number for the current year
        $lastRegNumber = DB::table($this->table)
            ->where($this->field, 'like', "%/{$year}")
            ->orderBy($this->field, 'desc')
            ->value($this->field);

        // Extract the numeric part of the last registration number
        $lastNumber = $lastRegNumber 
            ? intval(explode('/', $lastRegNumber)[0]) 
            : 0;

        // Increment the number
        $newNumber = $lastNumber + 1;

        // Format the registration number as '001/2025'
        $regNumber = "{$newNumber}/{$year}";

        return $regNumber;
    }

    /**
     * Check if a registration number already exists.
     *
     * @param string $regNumber
     * @return bool
     */
    public function isRegNumberExists(string $regNumber): bool
    {
        return DB::table($this->table)->where($this->field, $regNumber)->exists();
    }
}
