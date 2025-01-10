<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReferralController extends Controller
{
    public function getReferralData($registration_number)
    {
        Log::info("Fetching referral data for registration number: {$registration_number}");

        $child = DB::table('children')->where('registration_number', $registration_number)->first();

        if (!$child) {
            Log::warning("Child not found for registration number: {$registration_number}");
            return response()->json(['message' => 'Child not found'], 404);
        }

        Log::info("Child found: ", (array) $child);

        $referral = DB::table('referrals')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$referral) {
            Log::warning("No referrals found for child ID: {$child->id}");
            return response()->json(['message' => 'No referrals found for this child'], 404);
        }

        Log::info("Referral data fetched successfully: ", (array) $referral);

        return response()->json(['data' => json_decode($referral->data)]);
    }

    public function getChildData($registration_number)
    {
        Log::info("Fetching child data for registration number: {$registration_number}");

        $child = DB::table('children')->where('registration_number', $registration_number)->first();

        if (!$child) {
            Log::warning("Child not found for registration number: {$registration_number}");
            return response()->json(['message' => 'Child not found'], 404);
        }

        Log::info("Child data fetched successfully: ", (array) $child);

        return response()->json($child);
    }

    public function saveReferral($registration_number, Request $request)
    {
        Log::info("Saving referral for registration number: {$registration_number}");

        $data = $request->validate([
            'specialists' => 'array',
            'summaryHistory' => 'string',
            'differentialDiagnosis' => 'string',
            'reasonsForReferral' => 'string',
            'referredTo' => 'string',
        ]);

        Log::info("Validated referral data: ", $data);

        $child = DB::table('children')->where('registration_number', $registration_number)->first();

        if (!$child) {
            Log::warning("Child not found for registration number: {$registration_number}");
            return response()->json(['message' => 'Child not found'], 404);
        }

        Log::info("Child found: ", (array) $child);

        $visit = DB::table('visits')
            ->where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$visit) {
            Log::warning("No visit found for child ID: {$child->id}");
            return response()->json(['message' => 'No visit found for this child'], 404);
        }

        Log::info("Visit found: ", (array) $visit);

        $staffId = auth()->user()->id;

        try {
            // Check if a referral exists for this visit
            $existingReferral = DB::table('referrals')
                ->where('visit_id', $visit->id)
                ->first();

            if ($existingReferral) {
                Log::info("Referral exists for visit ID: {$visit->id}. Updating referral...");

                DB::table('referrals')
                    ->where('id', $existingReferral->id)
                    ->update([
                        'data' => json_encode($data),
                        'updated_at' => now(),
                    ]);

                Log::info("Referral updated successfully for visit ID: {$visit->id}");
                return response()->json(['message' => 'Referral updated successfully']);
            } else {
                Log::info("No referral exists for visit ID: {$visit->id}. Creating a new referral...");

                DB::table('referrals')->insert([
                    'visit_id' => $visit->id,
                    'child_id' => $child->id,
                    'staff_id' => $staffId,
                    'data' => json_encode($data),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Log::info("Referral created successfully for visit ID: {$visit->id}");
                return response()->json(['message' => 'Referral saved successfully']);
            }
        } catch (\Exception $e) {
            Log::error("Failed to save referral: {$e->getMessage()}");
            return response()->json(['message' => 'Failed to save referral', 'error' => $e->getMessage()], 500);
        }
    }
}
