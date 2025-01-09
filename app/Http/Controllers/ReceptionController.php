<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceptionController extends Controller
{
    public function dashboard(){
        $dashboard=null;
        return view('reception.dashboard',compact('dashboard'));
    }
}
