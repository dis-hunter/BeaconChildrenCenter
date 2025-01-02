<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis; // Import the Diagnosis model
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function create()
    {
        // Data to be saved
        $data = [
            'visit_id' => 1,
            'child_id' => 1, // Use the correct field name from the model/migration
            'doctor_id' => 1,
            'data' => [
                'primary' => 'autism',
                'secondary' => 'constipation',
            ],
        ];

        // Create a new Diagnosis record
        $diagnosis = Diagnosis::create($data);

        // Output the 'data' field (decoded by the accessor in the model)
        dd($diagnosis->data);
    }
}
