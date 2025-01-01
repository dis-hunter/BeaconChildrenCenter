<?php

namespace App\Http\Controllers;

use App\Models\Children; // Ensure the model name matches your file structure
use App\Models\Parents; // Ensure the model name matches your file structure
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    public function create()
    {
        return view('reception.childregistration'); // Render the form view
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'surname' => 'required|string|max:255',
            'dob' => 'required|date',
            'birth_cert' => 'required|string|max:50',
            'gender_id' => 'required|integer',
            'registration_number' => 'required|string|max:20',
            'parent_id' => 'required|integer',
           
        ]);

        // Combine fullname fields into a JSON object
        $fullname = [
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'surname' => $validatedData['surname'],
        ];
        

        // Create the parent record
        $children = children::create([
            'fullname' => json_encode($fullname),
            'dob' => $validatedData['dob'],
            'gender_id' => $validatedData['gender_id'],
            'birth_cert' => $validatedData['birth_cert'],
            'registration_number' => $validatedData['registration_number'],
            'parent_id' => $validatedData['parent_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('children.create')->with('success', 'child record saved successfully!');
    }
    public function getPatientName($childId)
    {
        try {
            $patient = DB::table('children')
                ->where('id', $childId)
                ->first();
    
            if ($patient) {
                try {
                    $fullname = json_decode($patient->fullname);
    
                    if ($fullname && isset($fullname->first_name, $fullname->middle_name, $fullname->last_name)) {
                        $patientName = trim(
                            "{$fullname->first_name} {$fullname->middle_name} {$fullname->last_name}"
                        );
                    } else {
                        $patientName = $patient->fullname ?? 'N/A';
                    }
                } catch (\Exception $e) {
                    $patientName = 'N/A';
                }
    
                return response()->json([
                    'status' => 'success',
                    'patient_name' => $patientName,
                ]);
            }
    
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch patient name',
            ], 500);
        }
    }
    

}


