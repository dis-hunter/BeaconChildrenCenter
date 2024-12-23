<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\parents; // Import the Diagnosis model

use Illuminate\Http\Request;

class ParentsController extends Controller
{
    public function create()
    {
        // Data to be saved
        $data = [
            'full_name' =>'maximus aurelius',
            'dob' => '1985-05-15', // Example date of birth
            'gender_id' => 1, // Reference to gender table (e.g., 1 for Male)
            'telephone' => '123-456-7890', // Example phone number
            'national_id' => 'AB12345678', // Example national ID
            'employer' => 'Roman Empire Corp', // Example employer name
            'insurance' => 'Imperial Health Insurance', // Example insurance provider
            'email_address' => 'maximus.aurelius@example.com', // Example email
            'relationship_id' => 2, // Reference to relationships table
            'referer' => 'Marcus Aurelius', // Example referer
            'timestamps' => now(), // Current timestamp
        ];

        // Create a new Diagnosis record
        $parents = parents::create($data);

        // Output the 'data' field (decoded by the accessor in the model)
        dd($parents->data);
    }
}
