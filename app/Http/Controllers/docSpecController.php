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
use App\Models\DoctorSpecialization;

use Illuminate\Database\QueryException;

class docSpecController extends Controller
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

    public function showSpecializations()
    {
        // Fetch distinct specializations
        $specializations = DoctorSpecialization::select('specialization_id', 'specialization')->distinct()->get();
        return view('Receiptionist/visit', compact('specializations'));
    }

    public function specializationSearch(Request $request)
    {
        $validated = $request->validate([
            'specialization_id' => 'required|exists:doctor_specialization,specialization_id',
        ]);

        // Query for staff IDs with the selected specialization
        $staffIds = DoctorSpecialization::where('specialization_id', $validated['specialization_id'])
            ->pluck('staff_id');

        // Redirect to the staff controller with the list of staff IDs
        return redirect()->route('staff.fetch', ['staff_ids' => $staffIds->toArray()]);
    }
    public function getSpecializations()
    {
        // Fetch distinct specializations
        $specializations = DoctorSpecialization::select('id', 'specialization')->distinct()->get();

        // Return the data as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $specializations,
        ]);
    }

    public function getDoctorsBySpecialization(Request $request)
    {
        // Retrieve the specialization ID from the query parameters
        $specializationId = $request->query('specialization_id');

        // Fetch doctors with the matching specialization ID
        $doctors = Doctor::where('specialization_id', $specializationId)->get();

        // Return the data as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $doctors,
        ]);
    }
}
