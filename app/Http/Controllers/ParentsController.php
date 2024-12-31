<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\Parents; // Ensure the model name matches your file structure
use App\Models\Relationship;
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
            'lastname' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender_id' => 'required',
            'telephone' => 'required|string|max:15',
            'national_id' => 'required|string|max:20',
            'employer' => 'nullable|string|max:255',
            'insurance' => 'nullable|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'relationship_id' => 'required',
            'referer' => 'nullable|string|max:255',
        ]);

        // Combine fullname fields into a JSON object
        $fullname = [
            'firstname' => $validatedData['firstname'],
            'middlename' => $validatedData['middlename'],
            'lastname' => $validatedData['lastname'],
        ];
        

        // Create the parent record
        $parent = Parents::create([
            'fullname' => json_encode($fullname),
            'dob' => $validatedData['dob'],
            'gender_id' =>  Gender::where('gender', $validatedData['gender_id'])->value('id'),
            'telephone' => $validatedData['telephone'],
            'national_id' => $validatedData['national_id'],
            'employer' => $validatedData['employer'],
            'insurance' => $validatedData['insurance'],
            'email' => $validatedData['email'],
            'relationship_id' => Relationship::where('relationship',$validatedData['relationship_id'])->value('id'),
            'referer' => $validatedData['referer'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (!$parent) {
            return redirect()->back()->with('error', 'Parent Registration Failed. Try again!')->withInput($validatedData);
        }

        return redirect()->back()->with('success', 'Parent record saved successfully!');
    }
    
    public function search(Request $request)
    {
        $query = $request->input('telephone');

        // Fetch the parent record by telephone
        $parent = Parents::where('telephone', $query)->first();

        if ($parent) {
            return view('reception.child', ['parent' => $parent]);
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
