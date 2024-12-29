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
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sur_name' => 'required|string|max:255',
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
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'sur_name' => $validatedData['sur_name'],
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
    public function search(Request $request)
    {
        $query = $request->input('telephone');

        // Fetch the parent record by telephone
        $parent = Parents::where('telephone', $query)->first();

        if ($parent) {
            return view('reception.childregistration', ['parent' => $parent]);
        } else {
            return redirect()->back()->with('error', 'No parent found with the specified phone number.');
        }
    }
    
    public function getChildren(Request $request)
    {
        $validatedData = $request->validate([
            'telephone' => 'required|string|max:15',
        ]);

        // Search for the parent using the telephone
        $parent = Parents::where('telephone', $validatedData['telephone'])->first();

        if (!$parent) {
            return redirect()->back()->with('error', 'Parent not found.');
        }

        // Pass parent_id to the route for ChildrenController
        return redirect()->route('children.search', ['parent_id' => $parent->id]);
    }
}
