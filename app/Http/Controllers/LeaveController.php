<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\StaffLeave;
use App\Models\LeaveType;
use App\Models\User;

class LeaveController extends Controller
{
    public function create()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch leave types for dropdown
        $leaveTypes = LeaveType::all();

        return view('staff.leave_request', compact('user', 'leaveTypes'));
    }
    public function create2()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch leave types for dropdown
        $leaveTypes = LeaveType::all();

        return view('reception.leave', compact('user', 'leaveTypes'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'reason' => 'required|string',
            'leave_type_id' => 'required|exists:leave_types,id', // change this to 'leave_type_id'
        ]);
        

        // Create leave request
        StaffLeave::create([
            'staff_id' => Auth::id(), // Get logged-in user's ID
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'leave_type_id' => $request->input('leave_type_id') ,
            'status' => 'pending', // Default status
        ]);

        return response()->json(['message' => 'Leave request submitted successfully!']);

    }

    public function getLeaveFormData()
{
    $user = auth()->user(); // Get logged-in user

    // Fetch leave types from the database
    $leaveTypes = LeaveType::all();

    return response()->json([
        'user' => [
            'fullname' =>$user->fullname,
            'first_name' => $user->first_name,
            'middle_name' => $user->middle_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'telephone' => $user->telephone
        ],
        'leaveTypes' => $leaveTypes
    ]);
}
public function showUserLeaves()
{
    $user = auth()->user();

    // Fetch leave requests with the leave type
    $leaveRequests = StaffLeave::where('staff_id', $user->id)
        ->with('leaveType')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('staff.leave_requests', compact('leaveRequests'));
}

public function showUserLeaves2()
{
    $user = auth()->user();

    // Fetch leave requests with the leave type
    $leaveRequests = StaffLeave::where('staff_id', $user->id)
        ->with('leaveType')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('reception.leave', compact('leaveRequests'));
}
public function adminLeaveRequests()
{
    $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
    $endOfWeek = \Carbon\Carbon::now()->endOfWeek();

    // Fetch ALL leave requests created this week
    $leaveRequests = StaffLeave::whereBetween('created_at', [$startOfWeek, $endOfWeek])
        ->with(['user', 'leaveType'])
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($leaveRequests);
}


public function updateLeaveStatus(Request $request, $id)
{
    $leave = StaffLeave::findOrFail($id);
    $leave->status = $request->status;
    $leave->save();

    return response()->json(['message' => 'Leave status updated successfully!']);
}




}
