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
        // For testing purposes, you can change this value
        $currentDoctorId = 1; // This would normally come from auth()->user()->id
    
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
    
            // Check if the doctor_id matches
            if ($latestVisit->doctor_id !== $currentDoctorId) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Unauthorized: You are not the assigned doctor for this visit'
                ], 403);
            }
    
            DB::table('visits')
                ->where('id', $latestVisit->id)
                ->update([
                    'notes' => $validatedData['notes'],
                    'updated_at' => now(),
                    'completed' => true
                ]);
    
            return response()->json(['status' => 'success', 'message' => 'Notes updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

public function getDoctorNotes($registrationNumber)
{
    try {
        $child = DB::table('children')
            ->where('registration_number', $registrationNumber)
            ->first();

        if (!$child) {
            return response()->json(['status' => 'error', 'message' => 'Child not found'], 404);
        }

        $visits = DB::table('visits')
            ->join('staff', 'visits.doctor_id', '=', 'staff.id')
            ->where('child_id', $child->id)
            ->orderBy('visit_date', 'asc')
            ->select('visits.id', 'visits.doctor_id', 'visits.visit_date', 'visits.notes', 
                    'staff.fullname as doctor_name')
            ->get()
            ->map(function($visit) {
                $nameData = json_decode($visit->doctor_name, true);
                $visit->doctor_name = $nameData['first_name'] ?? 'Unknown';
                return $visit;
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'registration_number' => $registrationNumber,
                'visits' => $visits
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
}
