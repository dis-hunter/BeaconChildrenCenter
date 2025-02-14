<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ExpensesController extends Controller
{
    public function saveExpenses(Request $request)
{
    $validatedData = $request->validate([
        'category' => 'required|string',
        'description' => 'required|string',
        'fullname' => 'nullable|string',
        'amount' => 'required|integer',
        'payment_method' => 'required|string',
        'staff_id' => 'nullable|exists:staff,id'
    ]);
    
    try {
        // Insert data into the expenses table
        DB::table('expenses')->insert([
            'category' => $validatedData['category'],
            'description' => $validatedData['description'],
            'fullname' => $validatedData['fullname'],
            'amount' => $validatedData['amount'],
            'payment_method' => $validatedData['payment_method'],
            'staff_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return response()->json([
            'status' => 'success', 
            'message' => 'Expense saved successfully'
        ], 201);
    
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error', 
            'message' => $e->getMessage()
        ], 500);
    }
}
}