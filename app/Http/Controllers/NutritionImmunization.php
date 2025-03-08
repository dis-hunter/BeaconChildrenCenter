<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NutritionImmunization extends Controller
{
    public function getNutritionImmunization($registrationNumber)
    {
        // Fetch the child ID using the registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        // Fetch the Nutrition History record for the child
        $nutritionHistory = DB::table('nutrition_immunization')
            ->where('child_id', $child->id)->orderBy('created_at','desc')
            ->first();

        if ($nutritionHistory) {
            return response()->json(['data' => json_decode($nutritionHistory->data)], 200);
        } else {
            return response()->json(['data' => null, 'message' => 'No Nutrition/Immunization History found'], 200);
        }
    }

    public function saveNutritionImmunization(Request $request, $registrationNumber)
{
    // Validate the incoming request data
    $request->validate([
        'data' => 'required|array', // Ensure the data is an array
    ]);

    try {
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        $doctorId = auth()->user()->id; // Replace with your actual logic

        // Check if a record exists for the child and doctor
        $existingRecord = DB::table('nutrition_immunization')
                            ->where('child_id', $child->id)
                            ->where('doctor_id', $doctorId)
                            ->first();

        if ($existingRecord) {
            // Update the existing record
            DB::table('nutrition_immunization')
                ->where('id', $existingRecord->id)
                ->update([
                    'data' => json_encode($request->data),
                    'updated_at' => now(),
                ]);

            return response()->json(['message' => 'Nutrition/Immunization History updated successfully!']);
        } else {
            // Create a new record
            DB::table('nutrition_immunization')->insert([
                'child_id' => $child->id,
                'data' => json_encode($request->data),
                'doctor_id' => $doctorId,
                'updated_at' => now(),
                'created_at' => now(),
            ]);

            return response()->json(['message' => 'Nutrition/Immunization History saved successfully!']);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to save Nutrition/Immunization History', 'error' => $e->getMessage()], 500);
    }
}
}
