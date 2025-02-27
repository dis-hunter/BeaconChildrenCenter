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
        // 1. Eager load the child with related data in fewer queries
        $child = DB::table('children')
            ->select('children.*', 'gender.gender')
            ->leftJoin('gender', 'children.gender_id', '=', 'gender.id')
            ->where('children.registration_number', $registrationNumber)
            ->first();

        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        // 2. Get staff details once
        $staff_id = auth()->user()->id;
        $staff = DB::table('staff')
            ->where('id', $staff_id)
            ->select('specialization_id')
            ->first();

        // 3. Decode the fullname JSON for the child
        $fullname = json_decode($child->fullname);
        $fullName = trim(
            ($fullname->first_name ?? '') . ' ' . 
            ($fullname->middle_name ?? '') . ' ' . 
            ($fullname->last_name ?? '')
        );

        // 4. Get visit in the same query as the parents (using subquery)
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$visit) {
            return response()->json(['error' => 'No visit found for the child'], 404);
        }

        // 5. Get all parents in a single query
        $parents = DB::table('parents')
            ->select('parents.*')
            ->join('child_parent', 'parents.id', '=', 'child_parent.parent_id')
            ->where('child_parent.child_id', $child->id)
            ->get();

        // Process parent data
        $maleParentDetails = ['fullname' => 'N/A', 'telephone' => 'N/A', 'email' => 'N/A'];
        $femaleParentDetails = ['fullname' => 'N/A', 'telephone' => 'N/A', 'email' => 'N/A'];
        $preferNotToSayParentDetails = ['fullname' => 'N/A', 'telephone' => 'N/A', 'email' => 'N/A'];

        foreach ($parents as $parent) {
            $parentFullname = json_decode($parent->fullname);
            $formattedName = trim(
                ($parentFullname->first_name ?? '') . ' ' . 
                ($parentFullname->middle_name ?? '') . ' ' . 
                ($parentFullname->last_name ?? '')
            );
            
            $parentDetails = [
                'fullname' => $formattedName,
                'telephone' => $parent->telephone ?? 'N/A',
                'email' => $parent->email ?? 'N/A',
            ];
            
            switch ($parent->gender_id) {
                case 1: // Male
                    $maleParentDetails = $parentDetails;
                    break;
                case 2: // Female
                    $femaleParentDetails = $parentDetails;
                    break;
                case 3: // Prefer not to say
                    $preferNotToSayParentDetails = $parentDetails;
                    break;
            }
        }

        // 6. Define tables to fetch data from
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
        ];

        function formatDataSection($data, $sectionTitle) {
            if (!$data) {
                return "{$sectionTitle}: No data available.\n\n";
            }
        
            $formattedText = "{$sectionTitle}:\n";
            foreach ((array)$data as $key => $value) {
                $formattedKey = str_replace('_', ' ', $key);
                $formattedKey = ucwords($formattedKey);
        
                // Check if $value is an array and convert it to a string
                if (is_array($value)) {
                    $value = implode(', ', $value); // Convert array to a comma-separated string
                }
        
                $formattedText .= "{$formattedKey}: {$value}\n";
            }
            return $formattedText . "\n";
        }
        

        // 7. More efficient approach: Use a single chunked query to get data from all tables
        $doctorsNotes = "";
        
        // Chunk the tables to reduce query complexity
        $tableChunks = array_chunk($tables, 3);
        
        foreach ($tableChunks as $tableChunk) {
            $placeholders = implode(',', array_fill(0, count($tableChunk), '?'));
            
            // Get the latest records for each table in this chunk
            $records = DB::select("
                SELECT t.table_name, t.data
                FROM (
                    SELECT 
                        q.table_name,
                        q.data,
                        ROW_NUMBER() OVER (PARTITION BY q.table_name ORDER BY q.created_at DESC) as rn
                    FROM (
                        " . implode(' UNION ALL ', array_map(function($table) {
                            return "SELECT '{$table}' as table_name, data, created_at FROM {$table} WHERE child_id = ?";
                        }, $tableChunk)) . "
                    ) q
                ) t
                WHERE t.rn = 1
            ", array_merge(array_fill(0, count($tableChunk), $child->id)));
            
            // Process the results
            $recordsByTable = [];
            foreach ($records as $record) {
                $recordsByTable[$record->table_name] = $record;
            }
            
            // Generate the doctor's notes for this chunk
            foreach ($tableChunk as $table) {
                $sectionTitle = ucwords(str_replace('_', ' ', $table));
                
                if (isset($recordsByTable[$table])) {
                    $decodedData = json_decode($recordsByTable[$table]->data);
                    $doctorsNotes .= formatDataSection($decodedData, $sectionTitle);
                } else {
                    $doctorsNotes .= "{$sectionTitle}: No data available.\n\n";
                }
            }
        }

        // Return response based on request type
        $responseData = [
            'child' => $child,
            'child_id' => $child->id,
            'fullName' => $fullName,
            'gender' => $child->gender,
            'parents' => [
                'maleParent' => $maleParentDetails,
                'femaleParent' => $femaleParentDetails,
                'preferNotToSayParent' => $preferNotToSayParentDetails,
            ],
            'doctorsNotes' => $doctorsNotes,
            'specialization_id' => $staff->specialization_id
        ];

        if (request()->wantsJson() || request()->ajax()) {
            $responseData['staff_id'] = auth()->user()->id;
            return response()->json($responseData);
        }

        return view('therapists.occupationaltherapyDashboard', $responseData);
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
    Log::info('saveTherapyGoal called', ['request_data' => $request->all()]);

    $validatedData = $request->validate([
        'child_id' => 'required|exists:children,id',
        'staff_id' => 'required|integer|exists:staff,id',
        'therapy_id' => 'required|integer|exists:therapy,id',
        'data' => 'required|array', // Ensures that 'data' is an array
    ]);

    Log::info('Validated data:', $validatedData);

    try {
        // Fetch the latest visit_id for the provided child_id
        $latestVisit = DB::table('visits')
            ->where('child_id', $validatedData['child_id'])
            ->latest('id') // Order by 'id' descending
            ->first();

        if (!$latestVisit) {
            Log::warning('No visits found for child_id', ['child_id' => $validatedData['child_id']]);
            return response()->json(['status' => 'error', 'message' => 'No visits found for the provided child_id'], 404);
        }

        // Get the visit_id from the latest visit
        $visitId = $latestVisit->id;
        Log::info('Latest visit ID retrieved:', ['visit_id' => $visitId]);

        // Convert the 'data' array into a JSON string
        $jsonData = json_encode($validatedData['data'], JSON_THROW_ON_ERROR);
        Log::info('JSON encoded data:', ['json_data' => $jsonData]);

        // Insert data into the therapy_goals table
        DB::table('therapy_goals')->insert([
            'child_id' => $validatedData['child_id'],
            'staff_id' => auth()->user()->id,
            'therapy_id' => $validatedData['therapy_id'],
            'visit_id' => $visitId, // Use the fetched visit_id
            'data' => $jsonData, // Save the JSON-encoded string
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('Therapy goal successfully inserted into database', [
            'child_id' => $validatedData['child_id'],
            'staff_id' => auth()->user()->id,
            'therapy_id' => $validatedData['therapy_id'],
            'visit_id' => $visitId,
            'data' => $jsonData
        ]);

        return response()->json(['status' => 'success', 'message' => 'Therapy goals saved successfully'], 201);
    } catch (\JsonException $jsonException) {
        Log::error('JSON encoding error', ['exception' => $jsonException->getMessage()]);
        return response()->json(['status' => 'error', 'message' => 'Invalid JSON data provided'], 400);
    } catch (\Exception $e) {
        Log::error('Exception occurred in saveTherapyGoal', ['exception' => $e->getMessage()]);
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