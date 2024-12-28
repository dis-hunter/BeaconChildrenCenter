<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Staff;
use Illuminate\Database\QueryException;
class DoctorController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'specialization' => 'required|string|max:255',
        ]);

        try {
            // Save the data to the doctors table
            Doctor::create($validated);

            // Redirect or return a success response
            return redirect('/doctor_form')->with('success', 'Doctor added successfully!');
        } catch (QueryException $e) {
            // Handle SQL errors
            throw $e;
        }
    }

    public function index()
    {
        // Fetch doctors with their related staff data
        $doctors = Doctor::with('staff')->get();

        // Pass the data to the view
        return view('display_doctors', compact('doctors'));
    }
}