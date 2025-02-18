<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IcdSearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('search_term');

        // --- API Configuration ---
        $tokenEndpoint = env('ICD_TOKEN_ENDPOINT');
        $icdApiEndpoint = env('ICD_API_ENDPOINT');
        $clientId = env('ICD_CLIENT_ID');
        $clientSecret = env('ICD_CLIENT_SECRET');

try {
    // --- Get Access Token ---
    $tokenResponse = Http::asForm()->post($tokenEndpoint, [ // Make sure $tokenEndpoint is not null
        "client_id" => $clientId,
        "client_secret" => $clientSecret,
        "scope" => "icdapi_access",
        "grant_type" => "client_credentials",
    ]);

            $tokenResponse->throw(); // Throw an exception if the request failed

            $accessToken = $tokenResponse->json()['access_token'];

            // --- Search for Diseases ---
            $searchResponse = Http::withHeaders([
                "Authorization" => "Bearer " . $accessToken,
                "Accept" => "application/vnd.icd.api+json; version=v2",
                "Accept-Language" => "en",
                "API-Version" => "v2",
                "Content-Type" => "application/json",  // Add this header
            ])->get($icdApiEndpoint, [
                "q" => $searchTerm
            ]);

            $searchResponse->throw(); // Throw an exception if the request failed

            $results = $searchResponse->json();
            $entities = $results['destinationEntities'];

            // Extract the 'theCode' field from each entity
            foreach ($entities as &$entity) {
                $entity['code'] = $entity['theCode'];
            }

            return response()->json(['entities' => $entities]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred during the search.'], 500);
        }
    }
}