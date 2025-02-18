@extends('reception.layout')
@section('title','Visits | Reception')
@extends('reception.header')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset ('css/visit.css')}}">

<!-- Patient Details Card -->
<div class="card shadow-sm mt-3">
    <div class="card-header bg-secondary text-white">
        <h5>Patient Details</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-12">
                @if (!$children)
                <div class="card mb-2">
                    <div class="card-body justify-content-center">
                        <p>Patient not selected</p>
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
                                <a href="/patients/{{$item->id}}" class="btn btn-sm btn-primary">View Details</a>
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

<!-- Error Message -->
@if(session()->has('error'))
<p style="color: red;">{{ session()->get('error') }}</p>
@endif

<!-- Patient Selection Table -->
@if(isset($children) && $children->count() > 0)
<h3>Children Records</h3>
<table border="1" class="patient-table">
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
                <button type="button" class="select-child btn btn-primary btn-sm" data-child-id="{{ $child->id }}">
                    <span class="button-text">Select</span>
                    <span class="selected-text" style="display: none">Selected ✓</span>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
<!-- Appointment Form -->
<div class="appointment-form mt-4">
    <div class="form-group">
        <label for="specialization">Select Specialization:</label>
        <select name="specialization_id" id="specialization" class="form-control">
            <option value="">-- Select Specialization --</option>
        </select>
    </div>

    <div id="doctor-list" class="mt-3">
        <h3>Doctors</h3>
        <table border="1" id="doctor-table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div id="visitType" class="mt-3">
        <h3>Visit Type</h3>
        <select id="visit_type" class="form-control">
            <option value="" disabled selected>Select an option</option>
            <option value="1">Paediatric Consultation</option>
            <option value="3">Therapy Assessment</option>
            <option value="4">Occupational Therapy</option>
            <option value="5">Sensory Integration</option>
            <option value="6">Speech Therapy</option>
            <option value="7">Physiotherapy</option>
            <option value="8">Psychotherapy</option>
            <option value="11">Review</option>
            <option value="2">General Consultation</option>
            <option value="15">Developmental Reports</option>
            <option value="16">Medical Report</option>
            <option value="17">Therapy Reports</option>
        </select>
    </div>

    <div id="triage-selection" class="mt-3">
        <h3>Triage Selection</h3>
        <select id="triage_pass" class="form-control">
            <option value="" disabled selected>Select an option</option>
            <option value="false">Yes, needs triage</option>
            <option value="true">No, directly to doctor</option>
        </select>
    </div>

    <div id="paymentMode" class="mt-3">
        <h3>💳 Payment Mode</h3>
        <select id="payment_mode" class="form-control">
            <option value="" disabled selected>Select Payment Mode</option>
            <option value="1">Insurance</option>
            <option value="2">NCPD</option>
            <option value="3">Cash</option>
            <option value="4">Probono</option>
            <option value="5">Other</option>
        </select>
    </div>
    <div id="copaySection" class="mt-3">
    <h3>Copay Details</h3>
    <div class="form-check mb-2">
        <input type="checkbox" class="form-check-input" id="has_copay">
        <label class="form-check-label" for="has_copay">Has Copay</label>
    </div>
    <div id="copayAmountDiv" class="form-group" style="display: none;">
        <label for="copay_amount">Copay Amount:</label>
        <input type="number" step="0.01" class="form-control" id="copay_amount" placeholder="Enter copay amount">
    </div>
</div>

    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <div class="loading-text">Creating appointment...</div>
        </div>
    </div>
    <button id="submit-appointment" class="btn btn-primary mt-4">Create Visit</button>
</div>
<div id="loading-overlay" class="loading-overlay" style="display: none;">
    <div class="loading-card">
        <div class="spinner"></div>
        <div class="loading-status" id="loading-status">Creating visit...</div>
        <div class="loading-substatus" id="loading-substatus">Preparing data</div>
        <div class="loading-progress">
            <div class="loading-progress-bar" id="loading-progress-bar"></div>
        </div>
    </div>
</div>

<script>
    // Utility Functions
    const utils = {
        showLoading(tableId, message = 'Loading...') {
            const table = document.getElementById(tableId);
            if (!table) return;

            let loadingSpinner = table.previousElementSibling;
            if (!loadingSpinner?.classList.contains('loading-spinner')) {
                loadingSpinner = document.createElement('div');
                loadingSpinner.className = 'loading-spinner';
                loadingSpinner.innerHTML = `
                <div class="spinner"></div>
                <div class="loading-text">${message}</div>
            `;
                table.parentNode.insertBefore(loadingSpinner, table);
            }
            loadingSpinner.classList.add('active');
            table.classList.add('table-loading');
            document.getElementById('loading-overlay').style.display = 'flex';
            document.getElementById('submit-appointment').disabled = true;
        },

        hideLoading(tableId) {
            const table = document.getElementById(tableId);
            if (!table) return;
            const loadingSpinner = table.previousElementSibling;
            if (loadingSpinner?.classList.contains('loading-spinner')) {
                loadingSpinner.classList.remove('active');
            }
            table.classList.remove('table-loading');
            document.getElementById('loading-overlay').style.display = 'none';
            document.getElementById('submit-appointment').disabled = false;
        },

        getTodayDate() {
            return new Date().toISOString().split('T')[0];
        },

        parseFullName(fullnameString) {
            try {
                const data = typeof fullnameString === 'string' ? JSON.parse(fullnameString) : fullnameString;
                return {
                    firstName: data?.first_name || '',
                    lastName: data?.last_name || '',
                    middleName: data?.middle_name || ''
                };
            } catch (e) {
                console.warn('Error parsing fullname:', e);
                return {
                    firstName: '',
                    lastName: '',
                    middleName: ''
                };
            }
        }
    };

    // API Functions
    const api = {
        async fetchSpecializations() {
            const response = await fetch('/specializations');
            const data = await response.json();
            return data.status === 'success' ? data.data : [];
        },

        async fetchDoctors(specializationId) {
            utils.showLoading('doctor-table', 'Fetching doctors...');
            try {
                const response = await fetch(`/doctors?specialization_id=${specializationId}`);
                const data = await response.json();
                return data.status === 'success' ? data.data : [];
            } finally {
                utils.hideLoading('doctor-table');
            }
        },

        async submitAppointment(data) {
            console.log('Submitting appointment with data:', data); // Debug log

            try {
                const response = await fetch('/visits', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const responseText = await response.text();
                console.log('Raw server response:', responseText); // Debug log

                if (!response.ok) {
                    throw new Error(`Server Error: ${responseText}`);
                }

                try {
                    return JSON.parse(responseText);
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                    throw new Error('Invalid JSON response from server');
                }
            } catch (error) {
                console.error('Appointment submission error:', error);
                throw error;
            }
        }
    };
    // UI Functions
    const ui = {
        populateDoctorTable(doctors) {
            const tableBody = document.querySelector('#doctor-table tbody');
            tableBody.innerHTML = '';

            doctors.forEach(doctor => {
                const nameData = utils.parseFullName(doctor.fullname);
                const fullName = [nameData.firstName, nameData.middleName, nameData.lastName]
                    .filter(Boolean)
                    .join(' ') || 'Unknown Name';

                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${fullName}</td>
                <td>
                    <button class="doctor-select-btn" data-doctor-id="${doctor.id}">Select</button>
                </td>
            `;

                const button = row.querySelector('button');
                button.addEventListener('click', () => this.handleDoctorSelection(button, row));
                tableBody.appendChild(row);
            });
        },
        handleChildSelection() {
            const patientTable = document.querySelector('.patient-table');
            if (!patientTable) return;

            patientTable.addEventListener('click', (e) => {
                const selectButton = e.target.closest('.select-child');
                if (!selectButton) return;

                // Remove active class and reset text from all child selection buttons
                document.querySelectorAll('.select-child').forEach(btn => {
                    btn.classList.remove('active');
                    btn.querySelector('.button-text').style.display = 'inline';
                    btn.querySelector('.selected-text').style.display = 'none';
                });

                // Add active class and update text for selected button
                selectButton.classList.add('active');
                selectButton.querySelector('.button-text').style.display = 'none';
                selectButton.querySelector('.selected-text').style.display = 'inline';

                // Optional: Add selected class to parent row for visual feedback
                document.querySelectorAll('.patient-table tr').forEach(row => row.classList.remove('selected'));
                selectButton.closest('tr').classList.add('selected');

                const childId = selectButton.getAttribute('data-child-id');
                console.log('Selected child ID:', childId);
            });
        },


        handleDoctorSelection(button, row) {
            document.querySelectorAll('#doctor-table tr').forEach(r => r.classList.remove('selected'));
            document.querySelectorAll('.doctor-select-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.textContent = 'Select';
            });

            row.classList.add('selected');
            button.classList.add('active');
            button.textContent = 'Selected';
        },

        async initializeSpecializations() {
            const specializations = await api.fetchSpecializations();
            const dropdown = document.getElementById('specialization');
            dropdown.innerHTML = '<option value="">-- Select Specialization --</option>';
            specializations.forEach(spec => {
                dropdown.innerHTML += `<option value="${spec.id}">${spec.specialization}</option>`;
            });
        }
    };

    const loadingUI = {
    overlay: document.getElementById('loading-overlay'),
    status: document.getElementById('loading-status'),
    substatus: document.getElementById('loading-substatus'),
    progressBar: document.getElementById('loading-progress-bar'),
    
    show(mainStatus = 'Creating visit...') {
        this.overlay.style.display = 'flex';
        this.status.textContent = mainStatus;
        this.setProgress(0);
    },
    
    hide() {
        this.overlay.style.display = 'none';
        this.setProgress(0);
    },
    
    updateStatus(mainStatus, subStatus) {
        this.status.textContent = mainStatus;
        if (subStatus) {
            this.substatus.textContent = subStatus;
        }
    },
    
    setProgress(percent) {
        this.progressBar.style.width = `${percent}%`;
    }
};

    // Validation Functions
    const validation = {
   async prepareAppointmentData() {
    // Initialize data object first
    const data = {
        child_id: null,
        doctor_id: null,
        visit_type: null,
        payment_mode_id: null,
        triage_pass: null,
        visit_date: utils.getTodayDate(),
        source_type: 'Reception',
        source_contact: '123456789',
        staff_id: 3,
        created_at: utils.getTodayDate(),
        updated_at: utils.getTodayDate(),
        has_copay: false,
        copay_amount: null  // Set default to null
    };

    try {
        // Get references to DOM elements
        const activeChild = document.querySelector('.select-child.active');
        const activeDoctor = document.querySelector('.doctor-select-btn.active');
        const visitType = document.getElementById('visit_type');
        const paymentMode = document.getElementById('payment_mode');
        const triagePass = document.getElementById('triage_pass');
        const hasCopay = document.getElementById('has_copay');
        const copayAmount = document.getElementById('copay_amount');

        // Validate required elements exist
        if (!activeChild || !activeDoctor || !visitType || !paymentMode || !triagePass) {
            throw new Error('Required form elements not found');
        }

        // Validate values are selected/entered
        if (!activeChild.dataset.childId || 
            !activeDoctor.dataset.doctorId || 
            !visitType.value || 
            !paymentMode.value || 
            !triagePass.value) {
            throw new Error('Please fill in all required fields');
        }

        // Populate data object
        data.child_id = parseInt(activeChild.dataset.childId);
        data.doctor_id = parseInt(activeDoctor.dataset.doctorId);
        data.visit_type = parseInt(visitType.value);
        data.payment_mode_id = parseInt(paymentMode.value);
        data.triage_pass = triagePass.value === 'true';

        // Only handle copay if checkbox is checked
        if (hasCopay && hasCopay.checked) {
            data.has_copay = true;
            if (!copayAmount.value || isNaN(copayAmount.value) || parseFloat(copayAmount.value) <= 0) {
                throw new Error('Please enter a valid copay amount');
            }
            data.copay_amount = parseFloat(copayAmount.value);
        } else {
            // If copay is not checked, set these values explicitly
            data.has_copay = false;
            data.copay_amount = null;
        }

        // Validate only non-copay values if copay is not checked
        const requiredFields = ['child_id', 'doctor_id', 'visit_type', 'payment_mode_id'];
        for (const field of requiredFields) {
            if (data[field] === null || data[field] === undefined || Number.isNaN(data[field])) {
                throw new Error(`Invalid value for field: ${field}`);
            }
        }

        console.log('Prepared appointment data:', data);
        return data;

    } catch (error) {
        console.error('Error preparing appointment data:', error);
        throw error;
    }
},

    validateAppointmentData() {
    const required = {
        child: document.querySelector('.select-child.active'),
        doctor: document.querySelector('.doctor-select-btn.active'),
        visitType: document.getElementById('visit_type').value,
        paymentMode: document.getElementById('payment_mode').value,
        triagePass: document.getElementById('triage_pass').value
    };

    // Check required fields
    for (const [key, value] of Object.entries(required)) {
        if (!value) {
            return {
                isValid: false,
                message: `Please select a ${key.replace(/([A-Z])/g, ' $1').toLowerCase()}.`
            };
        }
    }

    // Check copay only if checkbox is checked
    const hasCopay = document.getElementById('has_copay');
    if (hasCopay && hasCopay.checked) {
        const copayAmount = document.getElementById('copay_amount').value;
        if (!copayAmount || isNaN(copayAmount) || parseFloat(copayAmount) <= 0) {
            return {
                isValid: false,
                message: 'Please enter a valid copay amount'
            };
        }
    }

    return {
        isValid: true
    };
}
};

    // Event Listeners
    document.addEventListener('DOMContentLoaded', async () => {
        ui.handleChildSelection();
        await ui.initializeSpecializations();

        document.getElementById('specialization').addEventListener('change', async (e) => {
            if (e.target.value) {
                const doctors = await api.fetchDoctors(e.target.value);
                ui.populateDoctorTable(doctors);
            }
        });
        document.getElementById('has_copay').addEventListener('change', function(e) {
    const copayAmountDiv = document.getElementById('copayAmountDiv');
    const copayAmount = document.getElementById('copay_amount');
    
    copayAmountDiv.style.display = e.target.checked ? 'block' : 'none';
    if (!e.target.checked) {
        copayAmount.value = ''; // Clear the copay amount when unchecked
        // Remove any validation error messages if they exist
        const errorMessage = copayAmountDiv.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    }

});

document.getElementById('submit-appointment').addEventListener('click', async () => {
    try {
        const validationResult = validation.validateAppointmentData();
        if (!validationResult.isValid) {
            alert(validationResult.message);
            return;
        }

        loadingUI.show();
        loadingUI.updateStatus('Creating visit...', 'Validating data');
        loadingUI.setProgress(20);

        const appointmentData = await validation.prepareAppointmentData();
        loadingUI.updateStatus('Creating visit...', 'Sending data to server');
        loadingUI.setProgress(40);

        try {
            const result = await api.submitAppointment(appointmentData);
            loadingUI.setProgress(80);
            loadingUI.updateStatus('Visit created!', 'Processing response');

            if (result.status === 'success') {
                loadingUI.updateStatus('Success!', 'Redirecting...');
                loadingUI.setProgress(100);
                
                // Show success message with confetti effect
                const successMessage = document.createElement('div');
                successMessage.className = 'alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3';
                successMessage.style.zIndex = '10000';
                successMessage.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        Visit created successfully!
                    </div>
                `;
                document.body.appendChild(successMessage);

                // Redirect to dashboard after 2 seconds
                setTimeout(() => {
                    successMessage.remove();
                    window.location.href = '/dashboard'; // Changed from reload() to redirect
                }, 2000);
            } else {
                loadingUI.hide();
                const errorMessage = result.message || 'Failed to create appointment';
                console.error('Server returned error:', result);
                alert(errorMessage);
            }
        } catch (error) {
            loadingUI.hide();
            console.error('Submission error details:', error);
            alert(`Error creating appointment: ${error.message}`);
        }
    } catch (error) {
        loadingUI.hide();
        console.error('Form error details:', error);
        alert(`Form error: ${error.message}`);
    }
});

    });
</script>

@endsection