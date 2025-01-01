<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Database\QueryException;

class DoctorController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'staff_id' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
        ]);

        try {
            // Save the data to the doctors table
            Doctor::create($validated);

            // Redirect or return a success response
            return redirect('/doctor_form')->with('success', 'Doctor added successfully!');
        } catch (QueryException $e) {
            // Check if the error is a foreign key violation
            if ($e->getCode() == '23503') {
                // Redirect back with an error message
                return redirect('/doctor_form')->withErrors(['staff_id' => 'The selected staff ID does not exist.']);
            }

            // For other SQL errors, you can handle them here or rethrow the exception
            throw $e;
        }
    }
}