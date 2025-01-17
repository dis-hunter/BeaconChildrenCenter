<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
   
    /**
     * Count today's visits for a child based on the registration number
     * and log the visit types.
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

        // Get today's date
        $today = now()->toDateString();

        // Fetch visits for today, including their visit_type details
        $visits = DB::table('visits')
            ->join('visit_type', 'visits.visit_type', '=', 'visit_type.id')
            ->where('visits.child_id', $child->id)
            ->whereDate('visits.visit_date', $today)
            ->select('visit_type.visit_type as visit_type_name')
            ->get();

        // Log the visit types to the console
        foreach ($visits as $visit) {
            logger('Visit Type: ' . $visit->visit_type_name);
        }

        // Return the count of visits
        return response()->json([
            'message' => 'Records found',
            'count' => $visits->count(),
        ]);
    }
}
