<?php

namespace App\Http\Controllers;

use App\Models\DoctorSpecialization;
use Illuminate\Http\Request;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        // Fetch all specializations
        $doctorSpecializations = DoctorSpecialization::all();

        // Pass the specializations to the view
        return view('doctorDash', compact('doctorSpecializations'));
    }

    public function getSpecialists(Request $request)
{
    $specialists = Specialist::where('specialization_id', $request->specialization_id)->get();

    return response()->json($specialists);
}

}

