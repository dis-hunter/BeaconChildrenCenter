<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParentsController extends Controller
{
    public function create()
    {
        // Data to be saved
        $data = [
            'fullname' => "maximus aurelius",
            'dob' => 1, // Use the correct field name from the model/migration
            'gender_id' => 1,
            'telephone' => 1,
            'email' => 1,
            'national_id' => 1,
            'employer' => 1,
            'insurance' => 1,
            'referer' => 1,
            'relationship' => 1,



           
        ];

        // Create a new Diagnosis record
        $diagnosis = Diagnosis::create($data);

        // Output the 'data' field (decoded by the accessor in the model)
        dd($diagnosis->data);
    }
}
