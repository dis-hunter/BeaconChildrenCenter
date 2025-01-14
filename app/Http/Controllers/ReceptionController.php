<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointments;
use App\Models\children;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class ReceptionController extends Controller
{
    public function dashboard()
    {
        $dashboard= new stdClass();
        $dashboard->appointments=Appointments::all();
        $dashboard->activeUsers=User::getActiveUsers();
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
