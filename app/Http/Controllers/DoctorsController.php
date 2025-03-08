<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import the Log facade
use App\Models\Doctor;
use App\Models\Staff;
use App\Models\DoctorSpecialization;

class DoctorsController extends Controller
{ 

    // Profile method
    public function profile()
    {
        // Example profile data
        $profile = [
            'fullname' => ['first_name' => 'Florence', 'last_name' => 'Oringe'],
            'telephone' => '123-456-7890',
            'email' => 'florence.oringe@example.com',
        ];

        return view('doctorDash', compact('profile'));
    }

    // Update Profile method
    public function updateProfile(Request $request)
    {
        // Logic to update the profile (you can replace this with database logic)
        $updatedProfile = $request->all();

        // Redirect back with success message
        return redirect()->route('doctor.profile')->with('success', 'Profile updated successfully!');
    }
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
            $height = $triageData->height;
            $head_circumference = $triageData->head_circumference;
            $blood_pressure = $triageData->blood_pressure;
            $pulse_rate = $triageData->pulse_rate;
            $respiratory_rate = $triageData->respiratory_rate;
            $oxygen_saturation = $triageData->oxygen_saturation;
            $MUAC = $triageData->MUAC; 

            // Pass the decoded triage data to the view
            return view('doctor', [
                'child' => $child,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'gender' => $gender,
                'triage' => $triage,
                'temperature' => $temperature,
                'weight' => $weight,
                'height' => $height,
                'head_circumference' => $head_circumference,
                'blood_pressure' => $blood_pressure,
                'pulse_rate' => $pulse_rate,
                'respiratory_rate' => $respiratory_rate,
                'oxygen_saturation' => $oxygen_saturation,
                'MUAC' => $MUAC
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


    public function getTriageData($registrationNumber)
    {
        try {
            Log::info("getTriageData called with registration number: " . $registrationNumber);
    
            $child = DB::table('children')->where('registration_number', $registrationNumber)->first();
    
            if (!$child) {
                Log::warning("Child not found for registration number: " . $registrationNumber);
                abort(404);
            }
    
            $triage = DB::table('triage')->where('child_id', $child->id)->orderBy('created_at', 'desc')->first();
    
            if (!$triage) {
                Log::warning("Triage data not found for child with registration number: " . $registrationNumber);
                return response()->json(null); // ✅ Return null instead of 404
            }
    
            $triageData = json_decode($triage->data);
    
            Log::info("Triage data retrieved: ", (array)$triageData);
    
            return response()->json($triageData);
        } catch (\Exception $e) {
            Log::error("Error in getTriageData: " . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
    

    public function saveCnsData(Request $request, $registrationNumber)
    {
        try {
            Log::info("saveCnsData called with registration number: " . $registrationNumber);
    
            // Start query logging
            DB::enableQueryLog();  // Enable query logging
    
            // Find child by registration number
            $child = DB::table('children')->where('registration_number', $registrationNumber)->first();
            if (!$child) {
                return response()->json(['error' => 'Child not found'], 404);
            }
    
            // Get the latest visit for the child from the visits table
            $visit = DB::table('visits')
                ->where('child_id', $child->id)
                ->orderBy('created_at', 'desc') // Order by the latest visit
                ->first();
    
            if (!$visit) {
                return response()->json(['error' => 'No visit found for the child'], 404);
            }
    
            // Create or update the CNS data with timestamps
            DB::table('cns')->updateOrInsert(
                [
                    'visit_id' => $visit->id, // Associate with visit
                    'child_id' => $child->id,
                    'doctor_id' => auth()->user()->id, // Replace with logic for the actual doctor ID
                ],
                [
                    'data' => json_encode($request->all()), // Ensure data is JSON encoded
                    'updated_at' => now(), // Update timestamp
                    'created_at' => DB::raw('COALESCE((SELECT created_at FROM cns WHERE visit_id = ' . $visit->id . ' AND child_id = ' . $child->id . ' LIMIT 1), NOW())') // Keep the original created_at if it exists, otherwise use NOW()
                ]
            );
    
            // Log all executed queries
            Log::info("Executed Queries: " . json_encode(DB::getQueryLog()));
    
            return response()->json(['message' => 'CNS data saved successfully'], 200);
    
        } catch (\Exception $e) {
            Log::error("Error in saveCnsData: " . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
    

    public function getMilestones($registrationNumber)
    {
       
      
    
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();
    
        if (!$child) {
            error_log("Child not found for registration number: $registrationNumber");
            return response()->json(['error' => 'Child not found'], 404);
        }
    
    
        $milestone = DB::table('development_milestones')
            ->where('child_id', $child->id)
            ->orderBy('updated_at', 'desc') // Order by updated_at to get the latest updated milestone
            ->first();
    
        
    
        // Return null if no milestone is found
        return response()->json(['data' => $milestone ? $milestone->data : null], 200);
    }
    
    
    public function saveMilestones(Request $request, $registrationNumber)
    {
        $child = DB::table('children')->where('registration_number', $registrationNumber)->first();
    
        if (!$child) {
            error_log("Child not found for registration number: $registrationNumber");
            return response()->json(['error' => 'Child not found'], 404);
        }
    
       
    
        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->latest()
            ->first();
    
        if (!$visit) {
            return response()->json(['error' => 'No visit found for the child'], 404);
        }
    
        $milestoneData = json_encode($request->data);
    
    
        DB::table('development_milestones')->updateOrInsert(
            [
                'visit_id' => $visit->id,
                'child_id' => $child->id,
                'doctor_id' => auth()->user()->id, // Replace with authenticated doctor ID
            ],
            ['data' => $milestoneData, 'updated_at' => now()]
        );
    
        
        return response()->json(['message' => 'Milestone data saved successfully'], 200);
    }
    

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
    
            // Retrieve the latest visit for the child
            $visit = DB::table('visits')
                ->where('child_id', $child->id)
                ->latest()
                ->first();
    
            // Check if a visit exists
            if (!$visit) {
                return response()->json(['error' => 'No visit found for the child'], 404);
            }
            $parentData = DB::table('child_parent')
                ->where('child_id', $child->id)
                ->join('parents', 'child_parent.parent_id', '=', 'parents.id')
                ->join('relationships', 'parents.relationship_id', '=', 'relationships.id')
                ->select(
                    'parents.fullname',
                    'parents.telephone',
                    'parents.email',
                    'relationships.relationship'
                )
                ->get();
                $parents = [];
            foreach ($parentData as $parent) {
                $fullname = json_decode($parent->fullname);
                $parents[$parent->relationship] = [
                    'fullname' => $fullname->first_name . ' ' . ($fullname->middle_name ?? '') . ' ' . $fullname->last_name,
                    'telephone' => $parent->telephone,
                    'email' => $parent->email,
                ];
            }
    
            Log::info('Parent Data for Child ' . $child->id . ':', $parents);
    
            // Fetch triage data
            $triage = DB::table('triage')->where('child_id', $child->id)->first();
            $triageData = $triage ? json_decode($triage->data) : null;
    
          // Fetch CNS data based on updated_at
            $cnsData = DB::table('cns')
                ->where('child_id', $child->id)
                ->orderBy('updated_at', 'desc') // Ensure latest record is fetched based on updated_at
                ->first();

            if ($cnsData) {

                $cnsData = json_decode($cnsData->data);
            } else {
            
                $cnsData = null;
            }

            $perinatalHistory = DB::table('perinatal_history')
                ->where('child_id', $child->id)
                ->latest()
                ->first();
            $perinatalHistory = $perinatalHistory ? json_decode($perinatalHistory->data) : null;
    
            // Fetch developmental milestones
            $milestones = DB::table('development_milestones')
                ->where('child_id', $child->id)
                ->latest()
                ->first();
            $milestonesData = $milestones ? json_decode($milestones->data) : null;
            
            $pastMedicalHistory = DB::table('past_medical_history')
                ->where('child_id', $child->id)
                ->latest()
                ->first();
            $pastMedicalHistory = $pastMedicalHistory ? json_decode($pastMedicalHistory->data) : null;
            
            $BehaviourAssessment = DB::table('behaviour_assessment')
                ->where('child_id', $child->id)
                ->latest()
                ->first();
            $BehaviourAssessment = $BehaviourAssessment ? json_decode($BehaviourAssessment->data) : null;
            
            $FamilySocialHistory = DB::table('family_social_history')
                ->where('child_id', $child->id)
                ->latest()
                ->first();
            $FamilySocialHistory = $FamilySocialHistory ? json_decode($FamilySocialHistory->data) : null;
    
            // Format the data in a readable format
            $doctorsNotes = "";
            
            // Format Triage Data
            $doctorsNotes .= "Triage:\n";
            if ($triageData) {
                foreach ($triageData as $key => $value) {
                    $formattedKey = ucwords(str_replace('_', ' ', $key));
                    $doctorsNotes .= "$formattedKey: $value\n";
                }
            } else {
                $doctorsNotes .= "No triage data available.\n";
            }
            $doctorsNotes .= "\n";
            
            // Format CNS Data
            $doctorsNotes .= "CNS Data:\n";
            if ($cnsData) {
                foreach ($cnsData as $key => $value) {
                    $formattedKey = ucwords(str_replace('_', ' ', $key));
                    $doctorsNotes .= "$formattedKey: $value\n";
                }
            } else {
                $doctorsNotes .= "No CNS data available.\n";
            }
            $doctorsNotes .= "\n";
            
            // Format Development Milestones
            $doctorsNotes .= "Development Milestones:\n";
            if ($milestonesData) {
                foreach ($milestonesData as $key => $value) {
                    $formattedKey = ucwords(str_replace('_', ' ', $key));
                    if ($value !== null) {
                        $doctorsNotes .= "$formattedKey: $value\n";
                    }
                }
            } else {
                $doctorsNotes .= "No development milestones data available.\n";
            }
            $doctorsNotes .= "\n";
            
            // Format Perinatal History
            $doctorsNotes .= "Perinatal History:\n";
            if ($perinatalHistory) {
                foreach ($perinatalHistory as $key => $value) {
                    $formattedKey = ucwords(str_replace('_', ' ', $key));
                    if ($value !== null) {
                        $doctorsNotes .= "$formattedKey: $value\n";
                    }
                }
            } else {
                $doctorsNotes .= "No perinatal history data available.\n";
            }
            $doctorsNotes .= "\n";
            
            // Format Past Medical History
            $doctorsNotes .= "Past Medical History:\n";
            if ($pastMedicalHistory) {
                foreach ($pastMedicalHistory as $key => $value) {
                    $formattedKey = ucwords(str_replace('_', ' ', $key));
                    if ($value !== null) {
                        $doctorsNotes .= "$formattedKey: $value\n";
                    }
                }
            } else {
                $doctorsNotes .= "No past medical history data available.\n";
            }
            $doctorsNotes .= "\n";
            
            // Format Behaviour Assessment
            $doctorsNotes .= "Behaviour Assessment:\n";
            if ($BehaviourAssessment) {
                foreach ($BehaviourAssessment as $key => $value) {
                    $formattedKey = ucwords(str_replace('_', ' ', $key));
                    if ($value !== null) {
                        $doctorsNotes .= "$formattedKey: $value\n";
                    }
                }
            } else {
                $doctorsNotes .= "No behaviour assessment data available.\n";
            }
            $doctorsNotes .= "\n";
            
            // Format Family Social History
            $doctorsNotes .= "Family Social History:\n";
            if ($FamilySocialHistory) {
                foreach ($FamilySocialHistory as $key => $value) {
                    $formattedKey = ucwords(str_replace('_', ' ', $key));
                    if ($value !== null) {
                        $doctorsNotes .= "$formattedKey: $value\n";
                    }
                }
            } else {
                $doctorsNotes .= "No family social history data available.\n";
            }
            
            // Pass all data to the view
            return view('doctor', [
                'child' => $child,
                'child_id' => $child->id,
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'gender' => $gender,
                'doctorsNotes' => $doctorsNotes,
                'parents' => $parents,
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error in getChildDetails: " . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function dashboard()
    {
        $doctor = auth()->user();
    
        // Log authenticated doctor
        Log::info('Authenticated Doctor:', ['doctor' => $doctor]);
    
        // Handle fullname (still check if it's an object or JSON string)
        if (is_object($doctor->fullname)) {
            $fullName = $doctor->fullname;
            Log::info('Fullname is already an object:', (array)$fullName);
        } else {
            $fullName = json_decode($doctor->fullname);
            Log::info('Fullname decoded from JSON:', (array)$fullName);
        }
    
        // Directly fetch specialization from User model
        $specialization = $doctor->specialization ? $doctor->specialization->specialization : null;
    
        // Log specialization
        if ($specialization) {
            Log::info('Doctor specialization found:', ['specialization' => $specialization]);
        } else {
            Log::warning('No specialization found for doctor with ID:', ['doctor_id' => $doctor->id]);
        }
    
        // Fetch all doctor specializations
        $doctorSpecializations = $doctor->specialization ? (object) [
            'id' => $doctor->specialization->id, 
            'specialization' => $doctor->specialization->specialization
        ] : null;
        
        
        return view('doctorDash', [
            'doctor' => $doctor,
            'firstName' => $fullName->first_name ?? null,
            'lastName' => $fullName->last_name ?? null,
            'specialization' => $specialization,
            'doctorSpecializations' => $doctorSpecializations, // Pass to the view
        ]);
    }
    
}

