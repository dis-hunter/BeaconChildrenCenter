<?php

namespace App\Http\Controllers;

use App\Models\ChildParent;
use App\Models\Children; // Ensure the model name matches your file structure
use App\Models\Gender;
use App\Models\Parents; // Ensure the model name matches your file structure
use App\Models\Relationship;
use App\Models\Triage;
use App\Models\Visits;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

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
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender_id' => 'required',
            'telephone' => 'required|string|max:15|unique:parents,telephone',
            'national_id' => 'required|string|max:20|unique:parents,national_id',
            'employer' => 'nullable|string|max:255',
            'insurance' => 'nullable|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'relationship_id' => 'required',
            'referer' => 'nullable|string|max:255',

            'firstname2' => 'required|string|max:255',
            'middlename2' => 'nullable|string|max:255',
            'lastname2' => 'required|string|max:255',
            'dob2' => 'required|date',
            'birth_cert' => 'required|string|max:50|unique:children,birth_cert',
            'gender_id2' => 'required',
            'registration_number' => 'required|string|max:20|unique:children,registration_number',
        ]);

        // Combine fullname fields into a JSON object
        $parent_fullname = [
            'first_name' => $validatedData['firstname'],
            'middle_name' => $validatedData['middlename'],
            'last_name' => $validatedData['lastname'],
        ];

        // Combine fullname fields into a JSON object
        $child_fullname = [
            'first_name' => $validatedData['firstname2'],
            'middle_name' => $validatedData['middlename2'],
            'last_name' => $validatedData['lastname2'],
        ];


        //transaction for data consistency
        try {
            DB::transaction(function () use ($parent_fullname, $child_fullname, $validatedData) {
                //Create the parent record
                $parent = Parents::create([
                    'fullname' => json_encode($parent_fullname),
                    'dob' => $validatedData['dob'],
                    'gender_id' =>  Gender::where('gender', $validatedData['gender_id'])->value('id'),
                    'telephone' => $validatedData['telephone'],
                    'national_id' => $validatedData['national_id'],
                    'employer' => $validatedData['employer'],
                    'insurance' => $validatedData['insurance'],
                    'email' => $validatedData['email'],
                    'relationship_id' => Relationship::where('relationship', $validatedData['relationship_id'])->value('id'),
                    'referer' => $validatedData['referer'],
                ]);

                // Create the parent record
                $children = children::create([
                    'fullname' => json_encode($child_fullname),
                    'dob' => $validatedData['dob2'],
                    'gender_id' => Gender::where('gender', $validatedData['gender_id2'])->value('id'),
                    'birth_cert' => $validatedData['birth_cert'],
                    'registration_number' => $validatedData['registration_number'],
                ]);

                $child_parent = ChildParent::create([
                    'parent_id' => $parent->id,
                    'child_id' => $children->id,
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput($validatedData);
        }

        return redirect()->back()->with('success', 'Record Saved Successfully!');
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
        if ($id) {
            $child = Children::findOrFail($id);
            $gender = Gender::find($child->gender_id);
            if($child->dob){
                $child->age=Carbon::parse($child->dob)->age;
            }else{
                $child->age='Unknown';
            }
            $last_visit=Visits::where('child_id',$child->id)
            ->orderBy('created_at','desc')
            ->first();
            $last_visit->visitType=DB::table('visit_type')->where('id',$last_visit->visit_type)->get();
            $triage=Triage::where('child_id',$child->id)
            ->orderBy('created_at','desc')
            ->first();
            $careplan = DB::table('careplan')
            ->where('child_id',$child->id)
            ->latest()
            ->first();
            $careplan_data=json_encode($careplan->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return view('reception.patients', compact('child','gender','last_visit','triage','careplan_data'));
        } else {
            return view('reception.patients');
        }
    }
}
