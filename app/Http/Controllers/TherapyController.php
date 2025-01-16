<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 

class TherapyController extends Controller
{
    public function show($registrationNumber)
     {
        $child = DB::table('children')
                    ->where('registration_number', $registrationNumber)
                    ->first();

        if (!$child) {
            abort(404);
        }

        // Decode the fullname JSON
        $fullname = json_decode($child->fullname);

        // Access the first_name, middle_name, and last_name
        $firstName = $fullname->first_name;
        $middleName = $fullname->middle_name;
        $lastName = $fullname->last_name;

        // Get the gender name from the gender table
        $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');

        // Fetch triage data for the child
        $triage = DB::table('triage')->where('child_id', $child->id)->first();

        if ($triage) {
            // Decode the triage data JSON
            $triageData = json_decode($triage->data);

            // Access the individual data points
            $temperature = $triageData->temperature;
            $weight = $triageData->weight;
            // $height = $triageData->height;
            // $head_circumference = $triageData->head_circumference;
            // $blood_pressure = $triageData->blood_pressure;
            // $pulse_rate = $triageData->pulse_rate;
            // $respiratory_rate = $triageData->respiratory_rate;
            // $oxygen_saturation = $triageData->oxygen_saturation;
            // $MUAC = $triageData->MUAC; 

            // Pass the decoded triage data to the view
            return view('therapists.occupationaltherapyDashboard', [
                'child' => $child,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'gender' => $gender,
                // 'triage' => $triage,
                // 'temperature' => $temperature,
                // 'weight' => $weight,
                // 'height' => $height,
                // 'head_circumference' => $head_circumference,
                // 'blood_pressure' => $blood_pressure,
                // 'pulse_rate' => $pulse_rate,
                // 'respiratory_rate' => $respiratory_rate,
                // 'oxygen_saturation' => $oxygen_saturation,
                // 'MUAC' => $MUAC
            ]);
        } else {
            // Handle case where no triage data is found
            return view('doctor', [
                'child' => $child,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'gender' => $gender,
                'triage' => null, 
            ]);
        }
    }
    
    //fix this later for the doctors notes in therapy
    public function getChildDetails($registrationNumber)
{
    try {
        // Retrieve child by registration number
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();
        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        // Decode the fullname JSON
        $fullname = json_decode($child->fullname);
        $firstName = $fullname->first_name ?? null;
        $middleName = $fullname->middle_name ?? null;
        $lastName = $fullname->last_name ?? null;

        // Get gender name
        $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');
        
        // Get the staff details
        $staff_id = auth()->user()->id;
        $staff = DB::table('staff')->where('id', $staff_id)->first();

        // Retrieve the latest visit for the child
        $visit = DB::table('visits')->where('child_id', $child->id)->latest()->first();
        if (!$visit) {
            return response()->json(['error' => 'No visit found for the child'], 404);
        }

        // Fetch additional child-related data
        $triage = DB::table('triage')->where('child_id', $child->id)->first();
        $triageData = $triage ? json_decode($triage->data) : null;

        $cnsData = DB::table('cns')->where('child_id', $child->id)->latest()->first();
        $cnsData = $cnsData ? json_decode($cnsData->data) : null;

        $perinatalHistory = DB::table('perinatal_history')->where('child_id', $child->id)->latest()->first();
        $perinatalHistory = $perinatalHistory ? json_decode($perinatalHistory->data) : null;

        $milestones = DB::table('development_milestones')->where('child_id', $child->id)->latest()->first();
        $milestonesData = $milestones ? json_decode($milestones->data) : null;

        $pastMedicalHistory = DB::table('past_medical_history')->where('child_id', $child->id)->latest()->first();
        $pastMedicalHistory = $pastMedicalHistory ? json_decode($pastMedicalHistory->data) : null;

        $BehaviourAssessment = DB::table('behaviour_assessment')->where('child_id', $child->id)->latest()->first();
        $BehaviourAssessment = $BehaviourAssessment ? json_decode($BehaviourAssessment->data) : null;

        $FamilySocialHistory = DB::table('family_social_history')->where('child_id', $child->id)->latest()->first();
        $FamilySocialHistory = $FamilySocialHistory ? json_decode($FamilySocialHistory->data) : null;

        $Therapy_Assessment = DB::table('therapy_assesment')->where('child_id', $child->id)->latest()->first();
        $Therapy_Assessment = $Therapy_Assessment ? json_decode($Therapy_Assessment->data) : null;

        $Therapy_Goals = DB::table('therapy_goals')->where('child_id', $child->id)->latest()->first();
        $Therapy_Goals = $Therapy_Goals ? json_decode($Therapy_Goals->data) : null;

        $Therapy_Session = DB::table('therapy_session_2')->where('child_id', $child->id)->latest()->first();
        $Therapy_Session = $Therapy_Session ? json_decode($Therapy_Session->data) : null;

        $Therapy_Individualized = DB::table('therapy_individualized')->where('child_id', $child->id)->latest()->first();
        $Therapy_Individualized = $Therapy_Individualized ? json_decode($Therapy_Individualized->data) : null;

        $Post_Session_Activities = DB::table('follow_up')->where('child_id', $child->id)->latest()->first();
        $Post_Session_Activities = $Post_Session_Activities ? json_decode($Post_Session_Activities->data) : null;

        // Retrieve parent details
        $parentId = DB::table('child_parent')->where('child_id', $child->id)->value('parent_id');
        if (!$parentId) {
            return response()->json(['error' => 'Parent not found for the child'], 404);
        }

        $parent = DB::table('parents')->where('id', $parentId)->first();
        if (!$parent) {
            return response()->json(['error' => 'Parent details not found'], 404);
        }

        $parentFullName = $parent->fullname ?? 'N/A';
        $parentTelephone = $parent->telephone ?? 'N/A';
        $parentEmail = $parent->email ?? 'N/A';

        // Prepare doctor's notes
        function formatKeyValue($data, $indent = 0) {
            if (!$data) return "No data available.";
            $output = "";
            $prefix = str_repeat(" ", $indent);
            foreach ($data as $key => $value) {
                if (is_object($value) || is_array($value)) {
                    $output .= "{$prefix}{$key}:\n" . formatKeyValue($value, $indent + 4);
                } else {
                    $output .= "{$prefix}{$key}: $value\n";
                }
            }
            return $output;
        }

        $doctorsNotes = "";
        $doctorsNotes .= $Therapy_Session 
            ? "Therapy Session plan and activities:\n" . formatKeyValue($Therapy_Session) . "\n\n" 
            : "Therapy Session plan and activities: No data available.\n\n";

        $doctorsNotes .= $Therapy_Individualized 
            ? "Therapy Individualized plan and strategies:\n" . formatKeyValue($Therapy_Individualized) . "\n\n" 
            : "Therapy Individualized plan and strategies: No data available.\n\n";

        $doctorsNotes .= $Therapy_Assessment 
            ? "Therapy Assessment:\n" . formatKeyValue($Therapy_Assessment) . "\n\n" 
            : "Therapy Assessment: No data available.\n\n";

        $doctorsNotes .= $Therapy_Goals 
            ? "Therapy Goals:\n" . formatKeyValue($Therapy_Goals) . "\n\n" 
            : "Therapy Goals: No data available.\n\n";

        $doctorsNotes .= $Post_Session_Activities 
            ? "Therapy Post Session Activities:\n" . formatKeyValue($Post_Session_Activities) . "\n\n" 
            : "Therapy Post Session Activities: No data available.\n\n";

        $doctorsNotes .= $milestonesData 
            ? "Milestones:\n" . formatKeyValue($milestonesData) . "\n\n" 
            : "Milestones: No data available.\n\n";

        $doctorsNotes .= $perinatalHistory 
            ? "Perinatal History:\n" . formatKeyValue($perinatalHistory) . "\n\n" 
            : "Perinatal History: No data available.\n\n";

        $doctorsNotes .= $pastMedicalHistory 
            ? "Past Medical History:\n" . formatKeyValue($pastMedicalHistory) . "\n\n" 
            : "Past Medical History: No data available.\n\n";

        $doctorsNotes .= $BehaviourAssessment 
            ? "Behavior Assessment:\n" . formatKeyValue($BehaviourAssessment) . "\n\n" 
            : "Behavior Assessment: No data available.\n\n";

        $doctorsNotes .= $FamilySocialHistory 
            ? "Family Social History:\n" . formatKeyValue($FamilySocialHistory) . "\n\n" 
            : "Family Social History: No data available.\n\n";

        // Return response
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'child' => $child,
                'child_id' => $child->id,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'gender' => $gender,
                'parent' => [
                    'fullname' => $parentFullName,
                    'telephone' => $parentTelephone,
                    'email' => $parentEmail,
                ],
                'doctorsNotes' => $doctorsNotes,
                'staff_id' => auth()->user()->id,
                'specialization_id' => $staff->specialization_id
            ]);
        }

        // Otherwise, return view
        return view('therapists.occupationaltherapyDashboard', [
            'child' => $child,
            'child_id' => $child->id,
            'firstName' => $firstName,
            'middleName' => $middleName,
            'lastName' => $lastName,
            'gender' => $gender,
            'parent' => [
                'fullname' => $parentFullName,
                'telephone' => $parentTelephone,
                'email' => $parentEmail,
            ],
            'doctorsNotes' => $doctorsNotes,
            'specialization_id' => $staff->specialization_id
        ]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}




public function OccupationTherapy($registrationNumber)
{
   $child = DB::table('children')
               ->where('registration_number', $registrationNumber)
               ->first();

   if (!$child) {
       abort(404);
   }

   // Decode the fullname JSON
   $fullname = json_decode($child->fullname);

   // Access the first_name, middle_name, and last_name
   $firstName = $fullname->first_name;
   $middleName = $fullname->middle_name;
   $lastName = $fullname->last_name;

   // Get the gender name from the gender table
   $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');

   // Fetch triage data for the child

   

       // Pass the decoded triage data to the view
       return view('therapists.occupationalTherapist', [
           'child' => $child,
           'child_id' => $child->id,
           'firstName' => $firstName,
           'middleName' => $middleName,
           'lastName' => $lastName,
           'gender' => $gender,
           
       ]);
 
       // Handle case where no triage data is found
     
   
} 

public function PsychoTherapy($registrationNumber)
{
   $child = DB::table('children')
               ->where('registration_number', $registrationNumber)
               ->first();

   if (!$child) {
       abort(404);
   }

   // Decode the fullname JSON
   $fullname = json_decode($child->fullname);

   // Access the first_name, middle_name, and last_name
   $firstName = $fullname->first_name;
   $middleName = $fullname->middle_name;
   $lastName = $fullname->last_name;

   // Get the gender name from the gender table
   $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');

   // Fetch triage data for the child

   

       // Pass the decoded triage data to the view
       return view('therapists.psychotherapyTherapist', [
           'child' => $child,
           'child_id' => $child->id,
           'firstName' => $firstName,
           'middleName' => $middleName,
           'lastName' => $lastName,
           'gender' => $gender,
           
       ]);
 
       // Handle case where no triage data is found
     
   
} 
public function NutritionalTherapy($registrationNumber)
{
   $child = DB::table('children')
               ->where('registration_number', $registrationNumber)
               ->first();

   if (!$child) {
       abort(404);
   }

   // Decode the fullname JSON
   $fullname = json_decode($child->fullname);

   // Access the first_name, middle_name, and last_name
   $firstName = $fullname->first_name;
   $middleName = $fullname->middle_name;
   $lastName = $fullname->last_name;

   // Get the gender name from the gender table
   $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');

   // Fetch triage data for the child

   

       // Pass the decoded triage data to the view
       return view('therapists.nutritionist', [
           'child' => $child,
           'child_id' => $child->id,
           'firstName' => $firstName,
           'middleName' => $middleName,
           'lastName' => $lastName,
           'gender' => $gender,
           
       ]);
 
       // Handle case where no triage data is found
     
   
} 
public function SpeechTherapy($registrationNumber)
{
   $child = DB::table('children')
               ->where('registration_number', $registrationNumber)
               ->first();

   if (!$child) {
       abort(404);
   }

   // Decode the fullname JSON
   $fullname = json_decode($child->fullname);

   // Access the first_name, middle_name, and last_name
   $firstName = $fullname->first_name;
   $middleName = $fullname->middle_name;
   $lastName = $fullname->last_name;

   // Get the gender name from the gender table
   $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');

   // Fetch triage data for the child

   

       // Pass the decoded triage data to the view
       return view('therapists.speechTherapist', [
           'child' => $child,
           'child_id' => $child->id,
           'firstName' => $firstName,
           'middleName' => $middleName,
           'lastName' => $lastName,
           'gender' => $gender,
           
       ]);
 
       // Handle case where no triage data is found
     
   
} 
public function PhysioTherapy($registrationNumber)
{
   $child = DB::table('children')
               ->where('registration_number', $registrationNumber)
               ->first();

   if (!$child) {
       abort(404);
   }

   // Decode the fullname JSON
   $fullname = json_decode($child->fullname);

   // Access the first_name, middle_name, and last_name
   $firstName = $fullname->first_name;
   $middleName = $fullname->middle_name;
   $lastName = $fullname->last_name;

   // Get the gender name from the gender table
   $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');

   // Fetch triage data for the child

   

       // Pass the decoded triage data to the view
       return view('therapists.physiotherapyTherapist', [
           'child' => $child,
           'child_id' => $child->id,
           'firstName' => $firstName,
           'middleName' => $middleName,
           'lastName' => $lastName,
           'gender' => $gender,
           
       ]);
 
       // Handle case where no triage data is found
     
   
} 






public function saveTherapyGoal(Request $request)
{
    $validatedData = $request->validate([
        'child_id' => 'required|exists:children,id',
        'staff_id' => 'required|integer|exists:staff,id',
        'therapy_id' => 'required|integer|exists:therapy,id',
        'data' => 'required|array', // Ensures that 'data' is an array
    ]);

    try {
        // Fetch the latest visit_id for the provided child_id
        $latestVisit = DB::table('visits')
            ->where('child_id', $validatedData['child_id'])
            ->latest('id') // Order by 'id' descending
            ->first();

        if (!$latestVisit) {
            return response()->json(['status' => 'error', 'message' => 'No visits found for the provided child_id'], 404);
        }

        // Get the visit_id from the latest visit
        $visitId = $latestVisit->id;

        // Convert the 'data' array into a JSON string
        $jsonData = json_encode($validatedData['data'], JSON_THROW_ON_ERROR);

        // Insert data into the therapy_goals table
        DB::table('therapy_goals')->insert([
            'child_id' => $validatedData['child_id'],
            'staff_id' =>auth()->user()->id,
            'therapy_id' => $validatedData['therapy_id'],
            'visit_id' => $visitId, // Use the fetched visit_id
            'data' => $jsonData, // Save the JSON-encoded string
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Therapy goals saved successfully'], 201);
    } catch (\JsonException $jsonException) {
        return response()->json(['status' => 'error', 'message' => 'Invalid JSON data provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
//Assessment handling like pushing to db

public function saveAssessment(Request $request)
{
    $validatedData = $request->validate([
        'child_id' => 'required|exists:children,id',
        'staff_id' => 'required|integer|exists:staff,id',
        'therapy_id' => 'required|integer|exists:therapy,id',
        'data' => 'required|array', // Ensures that 'data' is an array
    ]);

    try {
        // Fetch the latest visit_id for the provided child_id
        $latestVisit = DB::table('visits')
            ->where('child_id', $validatedData['child_id'])
            ->latest('id') // Order by 'id' descending
            ->first();

        if (!$latestVisit) {
            return response()->json(['status' => 'error', 'message' => 'No visits found for the provided child_id'], 404);
        }

        // Save the assessment data
        DB::table('therapy_assesment')->insert([
            'child_id' => $validatedData['child_id'],
            'staff_id' =>auth()->user()->id,
            'therapy_id' => $validatedData['therapy_id'],
            'visit_id' => $latestVisit->id,
            'data' => json_encode($validatedData['data']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Assessment saved successfully'], 201);
    } catch (\JsonException $jsonException) {
        return response()->json(['status' => 'error', 'message' => 'Invalid JSON data provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
public function saveIndividualized(Request $request)
{
    $validatedData = $request->validate([
        'child_id' => 'required|exists:children,id',
        'staff_id' => 'required|integer|exists:staff,id',
        'therapy_id' => 'required|integer|exists:therapy,id',
        'data' => 'required|array', // Ensures that 'data' is an array
    ]);

    try {
        // Fetch the latest visit_id for the provided child_id
        $latestVisit = DB::table('visits')
            ->where('child_id', $validatedData['child_id'])
            ->latest('id') // Order by 'id' descending
            ->first();

        if (!$latestVisit) {
            return response()->json(['status' => 'error', 'message' => 'No visits found for the provided child_id'], 404);
        }

        // Save the individualized data
        DB::table('therapy_individualized')->insert([
            'child_id' => $validatedData['child_id'],
            'staff_id' => auth()->user()->id,
            'therapy_id' => $validatedData['therapy_id'],
            'visit_id' => $latestVisit->id,
            'data' => json_encode($validatedData['data']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Individulaized plans and stategies saved successfully'], 201);
    } catch (\JsonException $jsonException) {
        return response()->json(['status' => 'error', 'message' => 'Invalid JSON data provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
public function saveSession(Request $request)
{
    $validatedData = $request->validate([
        'child_id' => 'required|exists:children,id',
        'staff_id' => 'required|integer|exists:staff,id',
        'therapy_id' => 'required|integer|exists:therapy,id',
        'data' => 'required|array', // Ensures that 'data' is an array
    ]);

    try {
        // Fetch the latest visit_id for the provided child_id
        $latestVisit = DB::table('visits')
            ->where('child_id', $validatedData['child_id'])
            ->latest('id') // Order by 'id' descending
            ->first();

        if (!$latestVisit) {
            return response()->json(['status' => 'error', 'message' => 'No visits found for the provided child_id'], 404);
        }

        // Save the individualized data
        DB::table('therapy_session_2')->insert([
            'child_id' => $validatedData['child_id'],
            'staff_id' => auth()->user()->id,
            'therapy_id' => $validatedData['therapy_id'],
            'visit_id' => $latestVisit->id,
            'data' => json_encode($validatedData['data']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Session saved successfully'], 201);
    } catch (\JsonException $jsonException) {
        return response()->json(['status' => 'error', 'message' => 'Invalid JSON data provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
//Follow up handling like pushing to db
public function saveFollowup(Request $request)
{
    $validatedData = $request->validate([
        'child_id' => 'required|exists:children,id',
        'staff_id' => 'required|integer|exists:staff,id',
        'therapy_id' => 'required|integer|exists:therapy,id',
        'data' => 'required|array', // Ensures that 'data' is an array
    ]);

    try {
        // Fetch the latest visit_id for the provided child_id
        $latestVisit = DB::table('visits')
            ->where('child_id', $validatedData['child_id'])
            ->latest('id') // Order by 'id' descending
            ->first();

        if (!$latestVisit) {
            return response()->json(['status' => 'error', 'message' => 'No visits found for the provided child_id'], 404);
        }

        // Save the individualized data
        DB::table('follow_up')->insert([
            'child_id' => $validatedData['child_id'],
            'staff_id' => auth()->user()->id,
            'therapy_id' => $validatedData['therapy_id'],
            'visit_id' => $latestVisit->id,
            'data' => json_encode($validatedData['data']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Follow up saved successfully'], 201);
    } catch (\JsonException $jsonException) {
        return response()->json(['status' => 'error', 'message' => 'Invalid JSON data provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
public function completedVisit(Request $request)
{
    try {
        // Validate the request
        $validated = $request->validate([
            'child_id' => 'required|integer'
        ]);

        // Update the latest visit for this child directly
        $updated = DB::table('visits')
            ->where('child_id', $validated['child_id'])
            ->latest()  // Orders by created_at DESC
            ->limit(1)  // Limits to the most recent record
            ->update([
                'completed' => true,
                'updated_at' => now()
            ]);

        if ($updated === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No active visit found for this child'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Visit marked as completed successfully'
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Error in completedVisit: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while processing your request'
        ], 500);
    }
}
}