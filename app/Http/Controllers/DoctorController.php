<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'staff_id' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
        ]);

        // Save the data to the doctors table
        Doctor::create($validated);

        // Redirect or return a success response
        return redirect('/doctor_form')->with('success', 'Doctor added successfully!');
    }
}