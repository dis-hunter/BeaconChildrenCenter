
<?php $__env->startSection('title','Visits | Reception'); ?>

<?php $__env->startSection('content'); ?>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<link rel="stylesheet" href="<?php echo e(asset ('css/visit.css')); ?>">

<!-- Patient Details Card -->
<div class="card shadow-sm mt-3">
    <div class="card-header bg-secondary text-white">
        <h5>Patient Details</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-12">
                <?php if(!$children): ?>
                    <div class="card mb-2">                         
                        <div class="card-body justify-content-center">
                            <p>Patient not selected</p>
                            <p>Search for Patient or <a href="/guardians">Register</a> a new patient</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card mb-2">                         
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4"><strong>Child Name:</strong> <?php echo e(($item->fullname->last_name ?? '').' '.($item->fullname->first_name ?? '').' '.($item->fullname->middle_name ?? '')); ?></div>
                                    <div class="col-md-4"><strong>Date of Birth:</strong> <?php echo e($item->dob); ?></div>
                                    <div class="col-md-4 text-end">
                                        <a href="/patients/<?php echo e($item->id); ?>" class="btn btn-sm btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Error Message -->
<?php if(session()->has('error')): ?>
    <p style="color: red;"><?php echo e(session()->get('error')); ?></p>
<?php endif; ?>

<!-- Patient Selection Table -->
<?php if(isset($children) && $children->count() > 0): ?>
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
            <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($child->id); ?></td>
                    <td><?php echo e(($child->fullname->first_name ?? '')); ?> <?php echo e(($child->fullname->last_name ?? '')); ?></td>
                    <td><?php echo e($child->dob); ?></td>
                    <td><?php echo e($child->gender_id); ?></td>
                    <td>
                        <button type="button" class="select-child btn btn-primary btn-sm" data-child-id="<?php echo e($child->id); ?>">
                            <span class="button-text">Select</span>
                            <span class="selected-text" style="display: none">Selected ✓</span>
                        </button>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>
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
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <div class="loading-text">Creating appointment...</div>
    </div>
</div>
    <button id="submit-appointment" class="btn btn-primary mt-4">Create Appointment</button>
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
            return { firstName: '', lastName: '', middleName: '' };
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

// Validation Functions
const validation = {
    async prepareAppointmentData() {
        try {
            const activeChild = document.querySelector('.select-child.active');
            const activeDoctor = document.querySelector('.doctor-select-btn.active');
            const visitType = document.getElementById('visit_type');
            const paymentMode = document.getElementById('payment_mode');
            const triagePass = document.getElementById('triage_pass');

            if (!activeChild || !activeDoctor || !visitType.value || !paymentMode.value || !triagePass.value) {
                throw new Error('Missing required fields');
            }

            const data = {
                child_id: parseInt(activeChild.dataset.childId),
                doctor_id: parseInt(activeDoctor.dataset.doctorId),
                visit_type: parseInt(visitType.value),
                payment_mode_id: parseInt(paymentMode.value),
                triage_pass: triagePass.value === 'true',
                visit_date: utils.getTodayDate(),
                source_type: 'Reception',
                source_contact: '123456789',
                staff_id: 3,
                appointment_id: null,  // Added this field
                created_at: utils.getTodayDate(),
                updated_at: utils.getTodayDate()
            };

            // Validate all fields have proper values
            for (const [key, value] of Object.entries(data)) {
                if (key === 'appointment_id') continue; // Skip validation for appointment_id since it can be null
                if (value === undefined || value === null || Number.isNaN(value)) {
                    throw new Error(`Invalid value for field: ${key}`);
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

        for (const [key, value] of Object.entries(required)) {
            if (!value) {
                return {
                    isValid: false,
                    message: `Please select a ${key.replace(/([A-Z])/g, ' $1').toLowerCase()}.`
                };
            }
        }

        return { isValid: true };
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

    document.getElementById('submit-appointment').addEventListener('click', async () => {
    try {
        const validationResult = validation.validateAppointmentData();
        if (!validationResult.isValid) {
            alert(validationResult.message);
            return;
        }

        utils.showLoading(); // Show loading state

        const appointmentData = await validation.prepareAppointmentData();
        
        try {
            const result = await api.submitAppointment(appointmentData);
            
            if (result.status === 'success') {
                alert('Appointment created successfully!');
                window.location.reload();
            } else {
                const errorMessage = result.message || 'Failed to create appointment';
                console.error('Server returned error:', result);
                alert(errorMessage);
            }
        } catch (error) {
            console.error('Submission error details:', error);
            alert(`Error creating appointment: ${error.message}`);
        }
    } catch (error) {
        console.error('Form error details:', error);
        alert(`Form error: ${error.message}`);
    } finally {
        utils.hideLoading(); // Hide loading state regardless of success/failure
    }
});
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('reception.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/reception/visits.blade.php ENDPATH**/ ?>