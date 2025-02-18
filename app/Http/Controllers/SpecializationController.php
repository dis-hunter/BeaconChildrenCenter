<?php

namespace App\Http\Controllers;

use App\Models\DoctorSpecialization;
use App\Models\Staff;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    /**
     * Get all doctor specializations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpecializations()
    {
        $specializations = DoctorSpecialization::select('id', 'specialization')->get();

        if ($specializations->isEmpty()) {
            return response()->json(['message' => 'No specializations found.'], 404);
        }

        return response()->json(['data' => $specializations]);
    }

    /**
     * Get staff based on specialization.
     *
     * @param int $specializationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpecialists($specializationId)
    {
        $specialists = Staff::where('specialization_id', $specializationId)
            ->select('id', 'fullname')
            ->get();

        if ($specialists->isEmpty()) {
            return response()->json(['message' => 'No specialists found for this specialization.'], 404);
        }

        return response()->json(['data' => $specialists]);
    }
}
