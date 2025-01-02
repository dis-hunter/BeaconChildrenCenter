<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Fetch staff data for dropdown.
     */
    public function index()
    {
        $staff = Staff::all(['id', 'fullname']); // Fetch only necessary fields
        return view('your-view-file', compact('staff'));
    }
    

    public function fetchStaff(Request $request)
    {
        try {
            // Retrieve staff_ids from the query
            $staffIds = $request->query('staff_ids');
            
            // Convert to array and clean
            $staffIdsArray = array_filter(explode(',', $staffIds));

            if (empty($staffIdsArray)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No staff IDs provided'
                ], 400);
            }

            // Fetch staff
            $staffDetails = Staff::whereIn('id', $staffIdsArray)
                ->select(['id', 'fullname'])
                ->get();

            if ($staffDetails->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No staff found for the provided IDs'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $staffDetails
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

}
    

