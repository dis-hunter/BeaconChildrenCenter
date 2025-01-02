<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visits;

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
            'doctor_id' => 'required|integer|exists:doctors,id',
            'appointment_id' => 'nullable|integer',
        ]);

        try {
            $visit = Visits::create([
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

            return response()->json(['status' => 'success', 'data' => $visit], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
