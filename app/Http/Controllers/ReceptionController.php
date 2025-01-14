<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\children;
use Illuminate\Http\Request;

class ReceptionController extends Controller
{
    public function dashboard()
    {
        $dashboard = null;
        return view('reception.dashboard', compact('dashboard'));
    }

    public function search($id = null)
    {
        $children = $id ? children::where('id',$id)->get() : null;
        return view('reception.visits', compact('children'));
    }

    public function calendar()
{
    return view('reception.reception_calendar'); // Path to your Blade file
}

}
