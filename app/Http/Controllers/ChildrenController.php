<?php

namespace App\Http\Controllers;

use App\Models\Careplan;
use App\Models\ChildParent;
use App\Models\children; // Ensure the model name matches your file structure
use App\Models\Follow_Up;
use App\Models\Gender;
use App\Models\Parents; // Ensure the model name matches your file structure
use App\Models\Prescription;
use App\Models\Referral;
use App\Models\Relationship;
use App\Models\Triage;
use App\Models\Visits;
use App\Services\RegistrationNumberManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ChildrenController extends Controller
{
    public function get()
    {
        $genders = Gender::select('id', 'gender')->get();
        $relationships = Relationship::select('id', 'relationship')->get();
        return view('reception.child', compact('relationships', 'genders')); // Render the form view
    }

    public function childGet($id = null)
    {
        return view('reception.search', [
            'parentId' => $id
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender_id' => 'required|integer',
            'telephone' => 'required|string|max:15|unique:parents,telephone',
            'national_id' => 'nullable|string|max:20|unique:parents,national_id',
            'employer' => 'nullable|string|max:255',
            'insurance' => 'nullable|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'relationship_id' => 'required|integer',
            'referer' => 'nullable|string|max:255',

            'firstname2' => 'required|string|max:255',
            'middlename2' => 'nullable|string|max:255',
            'lastname2' => 'nullable|string|max:255',
            'dob2' => 'nullable|date',
            'birth_cert' => 'nullable|string|max:50|unique:children,birth_cert',
            'gender_id2' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Failed to save new record...')
                ->withErrors($validator)
                ->withInput($request->all())
                ->with('showForm',true);
        }

        $validatedData = $validator->validated();

        $reg_no=new RegistrationNumberManager('children','registration_number');
        $regis=$reg_no->generateUniqueRegNumber();

        // Combine fullname fields into a JSON object
        $parent_fullname = [
            'first_name' => ucwords($validatedData['firstname']),
            'middle_name' => ucwords($validatedData['middlename']),
            'last_name' => ucwords($validatedData['lastname']),
        ];

        // Combine fullname fields into a JSON object
        $child_fullname = [
            'first_name' => ucwords($validatedData['firstname2']),
            'middle_name' => ucwords($validatedData['middlename2']),
            'last_name' => ucwords($validatedData['lastname2']),
        ];

        $parent_id=null;

        //transaction for data consistency
        try {
            DB::transaction(function () use ($parent_fullname, $child_fullname, $validatedData,$regis, &$parent_id) {
                //Create the parent record
                $parent = Parents::create([
                    'fullname' => $parent_fullname,
                    'dob' => $validatedData['dob'],
                    'gender_id' =>  $validatedData['gender_id'],
                    'telephone' => $validatedData['telephone'],
                    'national_id' => $validatedData['national_id'],
                    'employer' => $validatedData['employer'],
                    'insurance' => $validatedData['insurance'],
                    'email' => $validatedData['email'],
                    'relationship_id' => $validatedData['relationship_id'],
                    'referer' => $validatedData['referer'],
                ]);

                // Create the parent record
                $children = children::create([
                    'fullname' => $child_fullname,
                    'dob' => $validatedData['dob2'],
                    'gender_id' => $validatedData['gender_id2'],
                    'birth_cert' => $validatedData['birth_cert'],
                    'registration_number' => $regis,
                ]);

                $child_parent = ChildParent::create([
                    'parent_id' => $parent->id,
                    'child_id' => $children->id,
                ]);

                $parent_id=$parent->id;
            });
            return redirect()->route('guardians.search',['id'=>$parent_id])->with('success', 'Record Saved Successfully!');
        } catch (\Exception $e) {
            Log::error('Create Parent & child (Reception)',[$e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to save new record...')->withInput($validatedData)->with('showForm',true);
        }
    }

    public function search(Request $request)
    {
        $parent_id = $request->query('parent_id');

        // Fetch all children associated with the parent_id
        $children = Children::where('parent_id', $parent_id)->get();

        if ($children->isEmpty()) {
            return redirect()->back()->with('error', 'No children found for this parent.');
        }

        return view('receiptionist.visits', compact('children'));
    }
    public function getPatientName($childId)
    {
        try {
            $patient = DB::table('children')
                ->where('id', $childId)
                ->first();

            if ($patient) {
                try {
                    $fullname = json_decode($patient->fullname);

                    if ($fullname && isset($fullname->first_name, $fullname->middle_name, $fullname->last_name)) {
                        $patientName = trim(
                            "{$fullname->first_name} {$fullname->middle_name} {$fullname->last_name}"
                        );
                    } else {
                        $patientName = $patient->fullname ?? 'N/A';
                    }
                } catch (\Exception $e) {
                    $patientName = 'N/A';
                }

                return response()->json([
                    'status' => 'success',
                    'patient_name' => $patientName,
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch patient name',
            ], 500);
        }
    }



    public function patientGet($id = null)
{
    if (!$id) {
        return view('reception.patients', ['child' => null]);
    }

    $child = Children::with([
        'gender', 'parents',
        'visits' => fn($query) => $query
            ->where('child_id', $id)
            ->latest()
            ->take(1)
            ->with('visitType'),
        'triage' => fn($query) => $query
            ->where('child_id', $id)
            ->latest()
            ->take(1),
        'careplan' => fn($query) => $query
            ->where('child_id', $id)
            ->latest()
            ->take(1)
            ->with('doctor'), // Include doctor in the same query
        'prescription' => fn($query) => $query
            ->where('child_id', $id)
            ->latest()
            ->take(1)
            ->with('doctor'),
        'referral' => fn($query) => $query
            ->where('child_id', $id)
            ->latest()
            ->take(1)
            ->with('doctor'),
        'followUp' => fn($query) => $query
            ->where('child_id', $id)
            ->latest()
            ->take(1)
            ->with('doctor')
    ])->findOrFail($id);

    // Calculate age
    $child->age = $child->dob ? Carbon::parse($child->dob)->age : 'Unknown';

    // Get the actual related records from the loaded relationships
    $lastVisit = $child->visits->first();
    $triage = $child->triage->first();
    $careplan = $child->careplan->first();
    $prescription = $child->prescription->first();
    $referral = $child->referral->first();
    $therapist_careplan = $child->followUp->first();

    // Add careplan notes if exists
    if ($careplan) {
        $careplan->notes = Careplan::notes($careplan);
    }

    return view('reception.patients', [
        'child' => $child,
        'gender' => $child->gender ?? (object)['gender' => 'Unknown'],
        'last_visit' => $lastVisit,
        'triage' => $triage,
        'careplan' => $careplan,
        'prescription' => $prescription,
        'referral' => $referral,
        'therapist_careplan' => $therapist_careplan
    ]);
}



    public function showChildren()
    {
        $children = DB::table('children')->select('id', 'fullname', 'dob', 'birth_cert', 'gender_id', 'registration_number', 'created_at', 'updated_at')->get();
        return view('therapists.therapistsDashboard', ['children' => $children]);
    }

    public function showChildren2()
{
    // Retrieve children data with gender details
    $children = DB::table('children')
        ->join('gender', 'children.gender_id', '=', 'gender.id')
        ->select('children.id', 'children.fullname', 'children.dob', 'children.birth_cert', 'gender.gender', 'children.registration_number', 'children.created_at', 'children.updated_at')
        ->get()
        ->map(function ($child) {
            // Decode JSON for fullname
            if (is_string($child->fullname)) {
                $decodedOnce = json_decode($child->fullname);
                if (is_string($decodedOnce)) {
                    $child->fullname = json_decode($decodedOnce);
                } else {
                    $child->fullname = $decodedOnce;
                }
            }
            return $child;
        });

    // Add key metrics
    $totalPatients = DB::table('children')->count();

    // Get today's date
    $today = Carbon::today()->toDateString();

    // New registrations today
    $newRegistrations = DB::table('children')
        ->whereDate('created_at', $today)
        ->count();

    // Calculate today's revenue
    $todaysRevenue = DB::table('payments')
        ->whereDate('payment_date', $today)
        ->sum('amount');  // Sum of the 'amount' field for payments made today

        $staff = DB::table('staff')
        ->leftJoin('staff_leave', 'staff.id', '=', 'staff_leave.staff_id')
        ->leftJoin('roles', 'staff.role_id', '=', 'roles.id')
        ->select(
            'staff.fullname',
            'staff_leave.status as leave_status',
            'staff_leave.start_date',
            'staff_leave.end_date',
            'roles.role as role'
        )
        ->get()
        ->map(function ($staffMember) {
            // Decode JSON for staff fullname (first_name, middle_name, last_name)
            if (is_string($staffMember->fullname)) {
                $decodedName = json_decode($staffMember->fullname, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $staffMember->fullname = $decodedName;
                }
            }

            // Extract full name ensuring proper spacing
            $fullNameParts = [
                $staffMember->fullname['first_name'] ?? '',
                $staffMember->fullname['middle_name'] ?? '',
                $staffMember->fullname['last_name'] ?? '',
                $staffMember->fullname['firstname'] ?? '',
                $staffMember->fullname['middlename'] ?? '',
                $staffMember->fullname['lastname'] ?? ''
            ];
            $staffMember->full_name = trim(implode(' ', array_filter($fullNameParts)));

            // Determine leave status based on date range
            $today = date('Y-m-d');
            if ($staffMember->leave_status === 'approved' && $staffMember->start_date <= $today && $staffMember->end_date >= $today) {
                $staffMember->status = 'On Leave';
            } else {
                $staffMember->status = 'Available';
            }

            return $staffMember;
        });


    // Pass all data to the view
    return view('beaconAdmin', [
        'children' => $children,
        'totalPatients' => $totalPatients,
        'newRegistrations' => $newRegistrations,
        'todaysRevenue' => $todaysRevenue,  // Pass today's revenue
        'staff' => $staff,
    ]);
}

public function getGenderDistribution()
{
    // Fetch the gender distribution data
    $genderData = DB::table('children')
        ->join('gender', 'children.gender_id', '=', 'gender.id')
        ->select('gender.gender', DB::raw('COUNT(children.id) as count'))
        ->groupBy('gender.gender')
        ->get();

    return response()->json($genderData);
}

}






