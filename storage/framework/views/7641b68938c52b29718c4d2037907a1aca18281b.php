<!-- Search Form -->
 <h2>welcome</h2>
<form action="<?php echo e(route('parent.get-children')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <table>
        <tr>
            <td>Search by Telephone</td>
            <td><input type="text" name="telephone" placeholder="Enter Telephone" value="<?php echo e(old('telephone')); ?>"></td>
            <td><input type="submit" value="Search"></td>
        </tr>
    </table>
</form>

<!-- Error Message -->
<?php if(session()->has('error')): ?>
<p style="color: red;">
    <?php echo e(session()->get('error')); ?>

</p>
<?php endif; ?>

<?php if(isset($children) && $children->count() > 0): ?>
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
    <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($child->id); ?></td>
            <td><?php echo e(json_decode($child->fullname)->firstname); ?> <?php echo e(json_decode($child->fullname)->surname); ?></td>
            <td><?php echo e($child->dob); ?></td>
            <td><?php echo e($child->gender_id); ?></td>
            <td>
                <button type="button" class="select-child" data-child-id="<?php echo e($child->id); ?>">Select</button>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
    </table>
<?php endif; ?>

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
        <option value="1">Consultation</option>
        <option value="2">Follow-Up</option>
        <option value="3">Emergency</option>
        <option value="4">Walk-In</option>

    </select>
    <p id="output"></p>

</div>

<button id="submit-appointment">Create Appointment</button>


<!--  -->


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
    tableBody.innerHTML = ''; // Clear any existing rows

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
        button.addEventListener('click', () => {
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

 function getChildId()
{
    const selectButtons = document.querySelectorAll('.select-child');

        selectButtons.forEach(button => {
            button.addEventListener('click', () => {
                const childId = button.getAttribute('data-child-id');
                console.log('Selected child ID:', childId);
            });
        });
}

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



</script>
<?php /**PATH C:\Users\giftg\beaconfolder\BeaconChildrenCenter\resources\views/Receiptionist/visits.blade.php ENDPATH**/ ?>