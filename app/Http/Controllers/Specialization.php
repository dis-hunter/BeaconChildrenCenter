<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Specialization extends Controller
{
  
    public function showCalendar()
{
    // Fetch all specializations from the database
    $specializations = doctor_specialization::all(); // Assuming DoctorSpecialization is the model for your specialization table

    return view('calendar', compact('specializations'));
}

public function getDoctorsBySpecialization($specializationId)
{
    // Fetch doctors based on the specialization ID
    $doctors = staff::where('specialization_id', $specializationId)->get(); // Assuming Doctor is the model for your doctors table

    return response()->json($doctors);
}
}