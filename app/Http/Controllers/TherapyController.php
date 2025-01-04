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

        // Fetch triage data
        $triage = DB::table('triage')->where('child_id', $child->id)->first();
        $triageData = $triage ? json_decode($triage->data) : null;

        // Fetch CNS data
        $cnsData = DB::table('cns')
            ->where('child_id', $child->id)
            ->latest()
            ->first();
        $cnsData = $cnsData ? json_decode($cnsData->data) : null;
        
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


        // Pass all data to the view
       // Prepare the data for the textarea
$doctorsNotes = "";
$doctorsNotes .= $triageData ? "Triage Data:\n" . json_encode($triageData, JSON_PRETTY_PRINT) . "\n\n" : "Triage Data: No data available.\n\n";
$doctorsNotes .= $cnsData ? "CNS Data:\n" . json_encode($cnsData, JSON_PRETTY_PRINT) . "\n\n" : "CNS Data: No data available.\n\n";
$doctorsNotes .= $milestonesData ? "Milestones Data:\n" . json_encode($milestonesData, JSON_PRETTY_PRINT) . "\n\n" : "Milestones Data: No data available.\n\n";

$doctorsNotes .= $perinatalHistory ? "perinatalHistory Data:\n" . json_encode($perinatalHistory, JSON_PRETTY_PRINT) . "\n\n" : "perinatalHistory Data: No data available.\n\n";

$doctorsNotes .= $pastMedicalHistory ? "pastMedicalHistory Data:\n" . json_encode($pastMedicalHistory, JSON_PRETTY_PRINT) . "\n\n" : "pastMedicalHistory Data: No data available.\n\n";

$doctorsNotes .= $BehaviourAssessment ? "BehaviourAssessment Data:\n" . json_encode($BehaviourAssessment, JSON_PRETTY_PRINT) . "\n\n" : "BehaviourAssessment Data: No data available.\n\n";

$doctorsNotes .= $FamilySocialHistory ? "FamilySocialHistory Data:\n" . json_encode($FamilySocialHistory, JSON_PRETTY_PRINT) . "\n\n" : "FamilySocialHistory Data: No data available.\n\n";

// Pass the notes to the view
return view('doctor', [
    'child' => $child,
    'child_id'=>$child->id,
    'firstName' => $firstName,
    'middleName' => $middleName,
    'lastName' => $lastName,
    'gender' => $gender,
    'doctorsNotes' => $doctorsNotes,
]);

    } catch (\Exception $e) {
        Log::error("Error in getChildDetails: " . $e->getMessage());
        return response()->json(['error' => 'Internal server error'], 500);
    }
}


}
