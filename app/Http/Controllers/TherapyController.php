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

        // Decode the fullname JSON for the child
        $fullname = json_decode($child->fullname);
        $firstName = $fullname->first_name ?? null;
        $middleName = $fullname->middle_name ?? null;
        $lastName = $fullname->last_name ?? null;

        // Combine the child's names into a single string
        $fullName = trim("{$firstName} {$middleName} {$lastName}");

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

        // Define tables to fetch data from
        $tables = [
            'triage',
            'development_milestones',
            'perinatal_history',
            'therapy_session_2',
            'therapy_assesment',
            'therapy_goals',
            'past_medical_history',
            'prescriptions',
            'family_social_history',
            'diagnosis',
            'behaviour_assessment'
            // Add other tables here as needed
        ];

        // Function to format data consistently
        function formatDataSection($data, $sectionTitle) {
            if (!$data) {
                return "{$sectionTitle}: No data available.\n\n";
            }

            $formattedText = "{$sectionTitle}:\n";
            foreach ((array)$data as $key => $value) {
                $formattedKey = str_replace('_', ' ', $key);
                $formattedKey = ucwords($formattedKey);
                $formattedText .= "{$formattedKey}: {$value}\n";
            }
            return $formattedText . "\n";
        }

        // Retrieve parent details based on gender
        $parentIds = DB::table('child_parent')->where('child_id', $child->id)->pluck('parent_id');

        $maleParent = DB::table('parents')
            ->whereIn('id', $parentIds)
            ->where('gender_id', 1) // Male
            ->first();

        $femaleParent = DB::table('parents')
            ->whereIn('id', $parentIds)
            ->where('gender_id', 2) // Female
            ->first();

        $preferNotToSayParent = DB::table('parents')
            ->whereIn('id', $parentIds)
            ->where('gender_id', 3) // Prefer not to say
            ->first();

        // Function to format parent's full name
        function formatParentFullName($parent) {
            if ($parent) {
                $fullname = json_decode($parent->fullname);
                return trim("{$fullname->first_name} {$fullname->middle_name} {$fullname->last_name}");
            }
            return 'N/A';
        }

        // Assign formatted full names for each parent
        $maleParentDetails = $maleParent ? [
            'fullname' => formatParentFullName($maleParent),
            'telephone' => $maleParent->telephone ?? 'N/A',
            'email' => $maleParent->email ?? 'N/A',
        ] : ['fullname' => 'N/A', 'telephone' => 'N/A', 'email' => 'N/A'];

        $femaleParentDetails = $femaleParent ? [
            'fullname' => formatParentFullName($femaleParent),
            'telephone' => $femaleParent->telephone ?? 'N/A',
            'email' => $femaleParent->email ?? 'N/A',
        ] : ['fullname' => 'N/A', 'telephone' => 'N/A', 'email' => 'N/A'];

        $preferNotToSayParentDetails = $preferNotToSayParent ? [
            'fullname' => formatParentFullName($preferNotToSayParent),
            'telephone' => $preferNotToSayParent->telephone ?? 'N/A',
            'email' => $preferNotToSayParent->email ?? 'N/A',
        ] : ['fullname' => 'N/A', 'telephone' => 'N/A', 'email' => 'N/A'];

        // Initialize doctor's notes
        $doctorsNotes = "";
        
        // Fetch and format data from each table
        foreach ($tables as $table) {
            $data = DB::table($table)
                ->where('child_id', $child->id)
                ->latest()
                ->first();
            
            $sectionTitle = ucwords(str_replace('_', ' ', $table));
            
            if ($data) {
                $decodedData = json_decode($data->data);
                $doctorsNotes .= formatDataSection($decodedData, $sectionTitle);
            } else {
                $doctorsNotes .= "{$sectionTitle}: No data available.\n\n";
            }
        }

        // Return response for AJAX requests
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'child' => $child,
                'child_id' => $child->id,
                'fullName' => $fullName,
                'gender' => $gender,
                'parents' => [
                    'maleParent' => $maleParentDetails,
                    'femaleParent' => $femaleParentDetails,
                    'preferNotToSayParent' => $preferNotToSayParentDetails,
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
            'fullName' => $fullName,
            'gender' => $gender,
            'parents' => [
                'maleParent' => $maleParentDetails,
                'femaleParent' => $femaleParentDetails,
                'preferNotToSayParent' => $preferNotToSayParentDetails,
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