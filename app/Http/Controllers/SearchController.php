<?php

namespace App\Http\Controllers;

use App\Models\children;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {

            if(auth()->id() == 2 || auth()->id() == 5){
                $children = children::search($request->keyword)->take(5)->get();
                $guardians = [];
            }else {
                $children = children::search($request->keyword)->take(5)->get();
                $guardians = Parents::search($request->keyword)->take(5)->get();
            }

            return response()->json([
                'guardians' => $guardians,
                'patients' => $children
            ]);
        } catch (\Throwable $th) {
            Log::error('Search Error',[$th->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
