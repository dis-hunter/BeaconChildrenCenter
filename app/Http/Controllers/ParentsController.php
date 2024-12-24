<?php

namespace App\Http\Controllers;

use App\Models\Parents; // Ensure the model name matches your file structure
use Illuminate\Http\Request;

class ParentsController extends Controller
{
    public function create()
    {
        return view('reception.parentregistration'); // Render the form view
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'surname' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender_id' => 'required|integer',
            'telephone' => 'required|string|max:15',
            'national_id' => 'required|string|max:20',
            'employer' => 'nullable|string|max:255',
            'insurance' => 'nullable|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'relationship_id' => 'required|integer',
            'referer' => 'nullable|string|max:255',
        ]);

        // Combine fullname fields into a JSON object
        $fullname = [
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'surname' => $validatedData['surname'],
        ];
        

        // Create the parent record
        $parent = Parents::create([
            'fullname' => json_encode($fullname),
            'dob' => $validatedData['dob'],
            'gender_id' => $validatedData['gender_id'],
            'telephone' => $validatedData['telephone'],
            'national_id' => $validatedData['national_id'],
            'employer' => $validatedData['employer'],
            'insurance' => $validatedData['insurance'],
            'email' => $validatedData['email'],
            'relationship_id' => $validatedData['relationship_id'],
            'referer' => $validatedData['referer'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('parents.create')->with('success', 'Parent record saved successfully!');
    }
}
