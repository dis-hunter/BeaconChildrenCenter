<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Visits;
use App\Models\PaymentMode;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

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
            'payment_mode_id' => 'required|integer|exists:payment_modes,id', // Validate payment mode
            'triage_pass' => 'required|boolean',
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
                'payment_mode_id' => $validatedData['payment_mode_id'],
                'triage_pass' => $validatedData['triage_pass'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'Appointment created successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Error creating appointment: ' . $e->getMessage());
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
// public function getPaymentModes()
// {
//     try {
//         $paymentModes = DB::table('payment_modes')->select('id', 'payment_mode')->get();

//         return response()->json(['status' => 'success', 'data' => $paymentModes]);
//     } catch (\Exception $e) {
//         return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
//     }
    
// }
// public function showForm()
// {
//     $paymentModes = PaymentMode::all(); // Assuming a PaymentMode model exists
//     return view('your-view', compact('paymentModes'));
// }

}
