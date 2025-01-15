@extends('reception.layout')
@section('title','Visits | Reception')
@extends('reception.header')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset ('css/visit.css')}}">

 <!-- Children Card -->
 <div class="card shadow-sm mt-3">
    <div class="card-header bg-secondary text-white">
        <h5>Patient Details</h5>
    </div>
    <div class="card-body">
        <!-- List of Children -->
        <div class="row mb-3">
            <div class="col-md-12">
                @if (!$children)

                <div class="card mb-2">                         
                    <div class="card-body justify-content-center">
                        
                            <p>Patient not selected</p> <br>
                            <p>Search for Patient or <a href="/guardians">Register</a> a new patient</p>
                        
                    </div>
                </div>

                @else
                    
                @foreach ($children as $item)
                
                <div class="card mb-2">                         
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4"><strong>Child Name:</strong> {{($item->fullname->last_name ?? '').' '.($item->fullname->first_name ?? '').' '.($item->fullname->middle_name ?? '')}}</div>
                            <div class="col-md-4"><strong>Date of Birth:</strong> {{$item->dob}}</div>
                            <div class="col-md-4 text-end">
                                <a href="/patients/{{$item->id}}" class="btn btn-sm btn-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<h2>Search </h2>
<form action="{{ route('parent.get-children') }}" method="post">
    @csrf
    <table>
    <tr>
            <td>Search by Name</td>
            <td><input type="text" name="child_name" placeholder="Enter Name" value="{{ old('fullname') }}"></td>
            <td><input type="submit" value="Search"></td>
        </tr>
        <tr>
            <td>Search by Telephone</td>
            <td><input type="text" name="telephone" placeholder="Enter Telephone" value="{{ old('telephone') }}"></td>
            <td><input type="submit" value="Search"></td>
        </tr>
    </table>    
</form>

<!-- Error Message -->
@if(session()->has('error'))
<p style="color: red;">
    {{ session()->get('error') }}
</p>
@endif

@if(isset($children) && $children->count() > 0)
    <h3>Children Records</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($children as $child)
                <tr>
                    <td>{{ $child->id }}</td>
                    <td>{{ ($child->fullname->first_name ?? '') }} {{ ($child->fullname->last_name ?? '') }}</td>
                    <td>{{ $child->dob }}</td>
                    <td>{{ $child->gender_id }}</td>
                    <td>
    <button type="button" class="select-child" data-child-id="{{ $child->id }}">Select</button>
</td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endif



<label for="specialization">Select Specialization:</label>
<select name="specialization_id" id="specialization">
    <option value="">-- Select Specialization --</option>
</select>

<div id="doctor-list">
    <h3>Doctors</h3>
    <table border="1" id="doctor-table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Doctor rows will be dynamically inserted here -->
        </tbody>
    </table>
</div>
<div id="visitType">
    <h3>Visit Type</h3>
    <select id="visit_type" onchange="showValue()">
    <option value="" disabled selected>Select an option</option>
    <option value="1">Developmental Assessment</option>
    <option value="2">Paediatric Consultation</option>
    <option value="3">General Consultation</option>
    <option value="4">Therapy Assessment</option>
    <option value="5">Therapy Session</option>
    <option value="6">Nutrition Session</option>
    <option value="7">Psychotherapy Session</option>
    <option value="8">Specific Developmental Tests</option>
    <option value="9">Review</option>
    <option value="10">Other</option>
</select>
    <p id="output"></p>
</div>

<div id="triage-selection">
    <h3>Triage Selection</h3>
    <label for="triage_pass">Does the patient need triage?</label>
    <select id="triage_pass">
        <option value="" disabled selected>Select an option</option>
        <option value="false">Yes, needs triage</option>
        <option value="true">No, directly to doctor</option>
    </select>
</div>

<div id="paymentMode">
<h3>💳 Payment Mode</h3>
<label for="payment_mode"><strong>Select Payment Mode:</strong></label>
<select id="payment_mode"  onchange="showPayment()" name="payment_mode" style="width: 200px; padding: 5px; margin-top: 10px;">
    <option value="" disabled selected>Select Payment Mode</option>
    <option value="1">Insurance</option>
      <option value="2">NCPD</option>
      <option value="3">Cash</option>
      <option value="4">Probono</option>
      <option value="5">Other</option>
      
</select>
<p id="output"></p>
</div>

<button style="background-color: #4f46e5" style="border-radius: 5%" id="submit-appointment">Create Appointment</button>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    console.log("welcome");
    getChildId();
    console.log(getTodayDate());
    displayCurrentAndFutureTime();
     
    // Fetch specializations
    fetchSpecializations();
    
});


// Function to fetch specializations
async function fetchSpecializations() {
    try {
        const response = await fetch('/specializations'); // Adjust the URL if needed
        const data = await response.json();

        if (data.status === 'success') {
            const specializations = data.data;
            console.log("this is:", specializations);

            const dropdown = document.getElementById('specialization');
            // Clear existing options
            dropdown.innerHTML = '<option value="">-- Select Specialization --</option>';

            // Populate dropdown
            specializations.forEach(specialization => {
                const option = document.createElement('option');
                option.value = specialization.id;
                option.textContent = specialization.specialization;
                dropdown.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error fetching specializations:', error);
    }
}

// Function to fetch doctors based on specialization
async function fetchDoctors(specializationId) {
    try {
        const response = await fetch(`http://127.0.0.1:8000/doctors?specialization_id=${specializationId}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Doctors response:', data);

        if (data.status === 'success' && data.data) {
            console.log(data.data);
            return data.data; // Return full doctor objects
        } else {
            return [];
        }
    } catch (error) {
        console.error('Error fetching doctors:', error);
        return [];
    }
}
// Fetch Payment Modes
// async function fetchPaymentModes() {
//     try {
//         const response = await fetch('/payment-modes');
//         const data = await response.json();

//         if (data.status === 'success') {
//             const paymentDropdown = document.getElementById('payment_type');
//             paymentDropdown.innerHTML = '<option value="">-- Select Payment Method --</option>';

//             data.data.forEach(mode => {
//                 const option = document.createElement('option');
//                 option.value = mode.id;
//                 option.textContent = mode.mode_name;
//                 paymentDropdown.appendChild(option);
//             });
//         }
//     } catch (error) {
//         console.error('Error fetching payment modes:', error);
//     }
// }

// Call on page load
// document.addEventListener('DOMContentLoaded', fetchPaymentModes);



// const selectedPaymentMode = document.getElementById('payment_mode').value;
// if (!selectedPaymentMode) {
//     alert('Please select a payment mode.');
//     return;
// }
// dataToSend.payment_mode_id = parseInt(selectedPaymentMode);



// Function to fetch staff names based on staff IDs
// async function fetchStaffNames(staffIds) {
//     try {
//         const response = await fetch(`http://127.0.0.1:8000/staff/names?staff_ids=${staffIds.join(',')}`);
        
//         if (!response.ok) {
//             const errorText = await response.text();
//             console.error('Staff response error:', errorText);
//             throw new Error(`Staff fetch failed: ${response.status}`);
//         }

//         const data = await response.json();
//         console.log('Staff data:', data);

//         if (data.status === 'success') {
//             return data.data;
//         } else {
//             return [];
//         }
//     } catch (error) {
//         console.error('Error fetching staff names:', error);
//         return [];
//     }
// }
// Function to update the doctor table
function populateDoctorTable(staffData) {
    const tableBody = document.querySelector('#doctor-table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    staffData.forEach(doctor => {
        const row = document.createElement('tr');
        const nameCell = document.createElement('td');
        const actionCell = document.createElement('td');

        let fullName = "Unknown Name";
        if (doctor.fullname) {
            try {
                fullName = JSON.parse(doctor.fullname)?.first_name || "Unknown Name";
            } catch (e) {
                console.error("Error parsing fullname:", e);
            }
        }

        nameCell.textContent = fullName;

        const button = document.createElement('button');
        button.textContent = 'Select';
        button.setAttribute('data-doctor-id', doctor.id);
        button.addEventListener('click', () => {
            // Remove "active" class from all buttons
            document.querySelectorAll('#doctor-table button').forEach(btn => btn.classList.remove('active'));

            // Add "active" class to the clicked button
            button.classList.add('active');

            console.log(`Selected Doctor ID: ${doctor.id}`);
        });

        actionCell.appendChild(button);
        row.appendChild(nameCell);
        row.appendChild(actionCell);
        tableBody.appendChild(row);
    });
}





async function ListVariables()
{
    
}

function getChildId() {
    const selectButtons = document.querySelectorAll('.select-child');

    selectButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove .active class from all buttons
            selectButtons.forEach(btn => btn.classList.remove('active'));

            // Add .active class to the clicked button
            button.classList.add('active');

            // Log the selected child ID for debugging
            const childId = button.getAttribute('data-child-id');
            console.log('Selected child ID:', childId);
        });
    });
}

// Call getChildId when the DOM is loaded
document.addEventListener('DOMContentLoaded', getChildId);


// Call getChildId when the DOM is loaded


function getTodayDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-based
    const day = String(today.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}
function displayCurrentAndFutureTime() {
    const now = new Date();

    // Get current time
    const currentHours = String(now.getHours()).padStart(2, '0');
    const currentMinutes = String(now.getMinutes()).padStart(2, '0');
    const currentSeconds = String(now.getSeconds()).padStart(2, '0');
    const currentTime = `${currentHours}:${currentMinutes}:${currentSeconds}`;

    // Calculate time after 1 hour
    const futureTime = new Date(now.getTime() + 60 * 60 * 1000); // Add 1 hour in milliseconds
    const futureHours = String(futureTime.getHours()).padStart(2, '0');
    const futureMinutes = String(futureTime.getMinutes()).padStart(2, '0');
    const futureSeconds = String(futureTime.getSeconds()).padStart(2, '0');
    const oneHourLaterTime = `${futureHours}:${futureMinutes}:${futureSeconds}`;

    console.log(`Current Time: ${currentTime}`);
    console.log(`Time After 1 Hour: ${oneHourLaterTime}`);
}

// Example usage
displayCurrentAndFutureTime();
function showPayment() {
            const dropdown2 = document.getElementById('payment_mode');
            
            const output = document.getElementById('output');
            console.log(dropdown2.value);
            output.innerHtml = `Mode selected ${dropdown.value}`;
  }

function showValue() {
            const dropdown = document.getElementById('visit_type');
            
            const output = document.getElementById('output');
            console.log(dropdown.value);
            output.innerHtml = `You selected: ${dropdown.value}`;
        }

const dropdown = document.getElementById('specialization');
// Event listener for the specialization dropdown
dropdown.addEventListener('change', async function () {
    try {
        const selectedId = this.value;
        console.log('Selected Specialization ID:', selectedId);

        if (!selectedId) {
            console.log('No specialization selected');
            return;
        }

        // Fetch doctors
        const staffIds = await fetchDoctors(selectedId);

        if (staffIds.length === 0) {
            console.log('No staff IDs found');
            return;
        }

        // Fetch staff names
        // const staffData = await fetchStaffNames(staffIds);
        // console.log('Successfully fetched staff:', staffData);

        // Populate the doctor table
        populateDoctorTable(staffIds);
    } catch (error) {
        console.error('Error in fetch operation:', error);
    }
});

// Add event listener to "Submit Appointment" button
document.getElementById('submit-appointment').addEventListener('click', async function () {
    try {
        // Get selected child ID
        const activeChildElement = document.querySelector('.select-child.active');
        if (!activeChildElement) {
            alert('Please select a child before proceeding.');
            return;
        }
        const selectedChildId = parseInt(activeChildElement.getAttribute('data-child-id'));
        if (!selectedChildId || isNaN(selectedChildId)) {
            alert('An error occurred while retrieving the selected child. Please try again.');
            return;
        }

        // Get selected doctor ID
        const activeDoctorElement = document.querySelector('#doctor-table button.active');
        if (!activeDoctorElement) {
            alert('Please select a doctor before proceeding.');
            return;
        }
        const selectedDoctorId = parseInt(activeDoctorElement.getAttribute('data-doctor-id'));
        if (!selectedDoctorId || isNaN(selectedDoctorId)) {
            alert('An error occurred while retrieving the selected doctor. Please try again.');
            return;
        }

        // Get visit type
        const visitTypeDropdown = document.getElementById('visit_type');
        const visitType = parseInt(visitTypeDropdown.value);
        if (!visitType || isNaN(visitType)) {
            alert('Please select a valid visit type before proceeding.');
            return;
        }

        // Get payment Method
        const paymentDropdown = document.getElementById('payment_mode');
        const paymentModeId = parseInt(paymentDropdown.value);
        if (!paymentModeId || isNaN(paymentModeId)) {
            alert('Please select a valid payment method before proceeding.');
            return;
        }

        // Get triage pass
        const triagePassDropdown = document.getElementById('triage_pass');
        const triagePassValue = triagePassDropdown.value;
        if (!triagePassValue) {
            alert('Please select whether the patient needs triage.');
            return;
        }
        // Convert triage_pass to boolean
        const triagePass = triagePassValue.toLowerCase() === 'true';

        // Prepare data
        const todayDate = getTodayDate();
        const dataToSend = {
            child_id: selectedChildId,
            visit_type: visitType,
            visit_date: todayDate,
            source_type: 'MySource',
            source_contact: '123456249',
            staff_id: 3,
            doctor_id: selectedDoctorId,
            triage_pass: triagePass,
            payment_mode_id: paymentModeId,  // Added payment_mode_id
            appointment_id: null,
            created_at: todayDate,
            updated_at: todayDate,
        };

        console.log('Data to be sent to the controller:', dataToSend);

        const response = await fetch('/visits', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify(dataToSend),
        });

        const result = await response.json();
        console.log('Response from server:', result);

        if (response.ok && result.status === 'success') {
            alert('Appointment created successfully!');
            // Optionally redirect or refresh the page
            window.location.reload();
        } else {
            const errorMessage = result.errors ? Object.values(result.errors).flat().join('\n') : result.message;
            alert('Failed to create appointment: ' + errorMessage);
        }
    } catch (error) {
        console.error('Error details:', error);
        alert('An error occurred while creating the appointment. Please check the console for details.');
    }
});

// Helper function to get today's date in YYYY-MM-DD format
function getTodayDate() {
    const today = new Date();
    return today.toISOString().split('T')[0];
}

</script>

@endsection