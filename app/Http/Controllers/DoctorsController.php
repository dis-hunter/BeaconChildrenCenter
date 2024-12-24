<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorsController extends Controller
{
    public function show($registrationNumber)
    {
        $child = DB::table('children')
                    ->where('registration_number', $registrationNumber)
                    ->first();

        if (!$child) {
            abort(404);
        }

        // Decode the fullname JSON
        $fullname = json_decode($child->fullname);

        // Access the first_name, middle_name, and last_name
        $firstName = $fullname->first_name;
        $middleName = $fullname->middle_name;
        $lastName = $fullname->last_name;

        // Get the gender name from the gender table
        $gender = DB::table('gender')->where('id', $child->gender_id)->value('gender');

        // You can now use these variables in your view
        return view('doctor', [
            'child' => $child,
            'firstName' => $firstName,
            'middleName' => $middleName,
            'lastName' => $lastName,
            'gender' => $gender 
        ]);
    }
}