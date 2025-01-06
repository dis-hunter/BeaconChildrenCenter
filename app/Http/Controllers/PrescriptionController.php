<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PrescriptionController extends Controller
{

public function store(Request $request, $registrationNumber)
{
    Log::info("Registration number received: " . $registrationNumber);

    try {
        // Validate the incoming data
        $data = $request->validate([
            'drugs' => 'required|array',
            'drugs.*.*' => Rule::in([
                'paracet', 'ibuprofen', 'diclofenac', 'cyclopam', // Analgesics
                'amoxicillin', 'amox-clav', 'cefuroxime', 'cefixime', 'azithromycin', 'clarithromycin', 'cefazolin', // Antibiotics
                'clotrimazole', 'fluconazole', // Antifungals
                'albendazole', 'mebendazole', // Antihelminthics
                'cetrizine', 'chlorpheniramine', 'prednisone', // Antihistamines
                'risperidone', 'methylphenidate', 'aripiprazole', 'fluoxetine', 'baclofen', 'atomoxetine', 'lorazepam', 'buspirone', 'clonidine', 'guanfacine', // Antipsychotics
                'calcium', 'iron', 'multivitamins', 'omega3', 'abidec', 'folate', 'zinc', 'vitaminA', // Supplements
                'sodium_valproate', 'phenobarbital', 'phenytoin', 'topiramate', 'levetiracetam', 'clobazam', 'lamotrigine', 'clonazepam', 'carbamazepine', 'gabapentin' // Antiepileptics
            ]),
            'formulation' => 'required|in:syrup,tablet,capsule,drops,topical',
            'dose' => 'required|numeric|min:0',
            'units' => 'required|in:mg,ml,iu,drops,cm',
            'frequency' => 'required|in:od,bd,tds,qid,stat',
            'duration' => 'required|in:stat,days,weeks,months',
            'duration_text' => 'required_if:duration,days,weeks,months'
        ]);

        // Find the child by registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();

        if (!$child) {
            return response()->json(['message' => 'Child not found'], 404);
        }

        Log::info("Child found with ID: " . $child->id); // Log the child ID

        // Find the latest visit for the child (using a subquery for efficiency)
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->latest() // Use latest() to get the most recent visit
            ->first();

        if (!$visit) {
            Log::error("No visit found for child ID: " . $child->id); // Log the error with child ID
            return response()->json(['message' => 'No visit found for this child'], 404);
        }

        Log::info("Visit found with ID: " . $visit->id); // Log the visit ID

        // Prepare the data to be saved
        $prescriptionData = [
            'drugs' => $data['drugs'],
            'formulation' => $data['formulation'],
            'dose' => $data['dose'],
            'units' => $data['units'],
            'frequency' => $data['frequency'],
            'duration' => [
                'type' => $data['duration'],
                'value' => $data['duration'] === 'stat' ? null : $data['duration_text']
            ]
        ];

        DB::table('prescriptions')->insert([
            'visit_id' => $visit->id,
            'child_id' => $child->id,
            'staff_id' => 1,// Hardcoded staff ID for now
            'data' => json_encode($prescriptionData),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Prescription saved successfully'], 201);

    } catch (\Exception $e) {
        Log::error("Error saving prescription: {$e->getMessage()}");
        return response()->json(['error' => 'Failed to save prescription'], 500);
    }
}
}

                