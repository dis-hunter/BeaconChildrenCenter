<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Count today's visits for a child based on the registration number.
     *
     * @param string $registrationNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function countVisitsForToday($registrationNumber)
    {
        // Fetch the child ID using the registration number directly from the database
        $child = DB::table('children')
            ->where('registration_number', $registrationNumber)
            ->select('id')
            ->first();

        if (!$child) {
            return response()->json([
                'message' => 'Child not found',
                'count' => 0,
            ], 404);
        }

        // Count visits for today's date
        $today = now()->toDateString();
        $visitCount = DB::table('visits')
            ->where('child_id', $child->id)
            ->whereDate('visit_date', $today)
            ->count();

        return response()->json([
            'message' => 'Records found',
            'count' => $visitCount,
        ]);
    }
}
