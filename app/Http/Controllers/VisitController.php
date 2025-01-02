<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Visits;
use Illuminate\Routing\Controller;

class VisitController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'child_id' => 'required|exists:children,id',
            'visit_type' => 'required|integer',
            'visit_date' => 'required|date',
            'source_type' => 'required|string',
            'source_contact' => 'required|string|max:15',
            'staff_id' => 'required|integer|exists:staff,id',
            'doctor_id' => 'required|integer|exists:staff,id',
            'appointment_id' => 'nullable|integer',
        ]);

        try {
            DB::table('visits')->insert([
                'child_id' => $validatedData['child_id'],
                'visit_type' => $validatedData['visit_type'],
                'visit_date' => $validatedData['visit_date'],
                'source_type' => $validatedData['source_type'],
                'source_contact' => $validatedData['source_contact'],
                'staff_id' => $validatedData['staff_id'],
                'doctor_id' => $validatedData['doctor_id'],
                'appointment_id' => $validatedData['appointment_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['status' => 'success', 'data' => 'yes'], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function doctorNotes(Request $request)
{
    $validatedData = $request->validate([
        'child_id' => 'required|exists:children,id',
        'notes' => 'nullable|string'
    ]);

    try {
        $latestVisit = DB::table('visits')
            ->where('child_id', $validatedData['child_id'])
            ->latest()
            ->first();

        if (!$latestVisit) {
            return response()->json(['status' => 'error', 'message' => 'No visit found'], 404);
        }

        DB::table('visits')
            ->where('id', $latestVisit->id)
            ->update([
                'notes' => $validatedData['notes'],
                'updated_at' => now()
            ]);

        return response()->json(['status' => 'success', 'message' => 'Notes updated successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
}
