<!DOCTYPE html>
<html>
<head>
  <title>Therapist Dashboard</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/js/app.js','resources/css/app.css'])
    @livewireStyles
  <style>
    .selected-row {
    background-color: lightblue;
  }
     .sidebar {
      width: 200px;
      transition: width 0.3s ease;
    }

    .sidebar.collapsed {
      width: 40px;
    }

    .toggle-button {
      position: fixed;
      left: 200px;
      top: 20px;
      background-color: #111827;
      color: white;
      width: 24px;
      height: 24px;
      border-radius: 0 6px 6px 0;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: left 0.3s ease;
      z-index: 1000;
    }

    .toggle-button.collapsed {
      left: 40px;
    }

    .toggle-button::before {
      content: "◀";
      font-size: 12px;
      transition: transform 0.3s ease;
    }

    .toggle-button.collapsed::before {
      transform: rotate(180deg);
    }

    .main-content {
      margin-left: 200px;
      transition: margin-left 0.3s ease;
    }

    .main-content.collapsed {
      margin-left: 60px;
    }

    .close {
    position: absolute; /* Position it relative to the modal */
    top: 10px; /* Adjust this value to align properly */
    right: 10px; /* Adjust this value to align properly */
    cursor: pointer; /* Change cursor to indicate interactivity */
    font-size: 18px; /* Size of the close icon */
    color: #333; /* Default color for the icon */
    transition: color 0.3s ease, transform 0.3s ease; /* Add hover and interaction effects */
}

.close:hover {

    transform: scale(1.2); /* Slightly enlarge the icon on hover */
}


    .cancel-btn,
.reschedule-btn {
    display: none;
}

/* Dropdown Styling */
.dropdown-content {
    display: none; /* Initially hidden */
    position: absolute;
    background-color: white; /* Background color */
    color: black !important; /* Text color */
    min-width: 150px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    padding: 12px 16px;
    z-index: 1000;
    border-radius: 6px;
}

.dropdown-content a {
    color: black !important; /* Text color */
    padding: 8px 12px;
    text-decoration: none;
    display: block;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    transition: background-color 0.3s ease;
}

.dropdown-content a:last-child {
    border-bottom: none;
}

.dropdown-content a:hover {
    background-color: rgba(255, 255, 255, 0.1); /* Hover effect */
}

/* Show Dropdown on Hover */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Modal Styling */
#reschedule-modal {
    display: none; /* Initially hidden */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1100;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    max-width: 400px;
    width: 90%;
}

#reschedule-modal .close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    font-size: 18px;
    color: black;
}

.hidden {
    display: none;
}
.results-container{
  margin-right :50px !important;
}

/* Overlay for Modal */
.modal-overlay {
    display: none; /* Initially hidden */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

form {
  color:black !important;
}
.calendar-content{
  margin-left : 100px !important;
}
#patients {
  position: relative; /* Ensures only this section is affected */
  top: 15%; /* Moves the #patients section 40% down */
  width: 100%; /* Ensures it covers the full width */
}

.section {
  margin: 0;
  padding: 0;
  width: 100%; /* Ensures sections take up the full width */
}



/* .main-content header {
  padding: 10px;
  background-color: #f8f9fa;
  border-bottom: 1px solid #ddd;
  position: relative;
  top: 0;
  z-index: 10;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 1rem;
  border-bottom: 1px solid #ddd;
  width: 1070px !important;
} */


/* Ensure the header extends to the end */
/* header.bg-white.shadow {
  width: 100%;
} */



/* Ensure the main content takes up the remaining space */
/* Ensure the main content takes up the remaining space */


/* Ensure the header extends to the end */
/* header.bg-white.shadow {
  width: 100%;
} */

/* Dashboard Section */
/* #dashboard {
  margin-bottom: 15px; /* Add space between dashboard and patients section */
/* }
body{
  display: flex;
flex-direction: column; /* Stack elements vertically */
/* align-items: flex-start; Align content to the top */

/* }  */


/* Make the patients section appear immediately below the dashboard */
/* Limit the height of the patients section */
/* Update the patients section to appear at the top */
#patients {
  position: absolute; /* Position it absolutely */
  top: 100px; /* Position it right below the header */
  left: 0;
  width: 80% !important;
  margin-left: 220px !important;
  margin-bottom: 0 !important;
  z-index: 10; /* Ensure it appears above other elements */
}

/* Ensure the dashboard doesn't overlap with patients when both are visible */
/* Enlarge dashboard cards */
/* #dashboard > div { */
  /* padding: 2rem !important; Increase internal padding (from p-6 to larger) */
  /* min-height: 220px; Set minimum height */
  /* display: flex; */
  /* flex-direction: column; */
  /* justify-content: center; */
/* } */

/* Make icons larger */
/* #dashboard > div i.fas {
  font-size: 2.5rem !important;
  margin-bottom: 2rem !important;
} */

/* Make headings larger */
/* #dashboard > div h3 {
  font-size: 1.5rem !important; /
  margin-bottom: 0.75rem !important;
} */

/* Make description text larger */
/* #dashboard > div p {
  font-size: 1.125rem !important;
  line-height: 1.5;
} */
/* Add Event Modal Styling */
.add-event-wrapper {
  display: none; /* Hidden by default */
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
  z-index: 1000; /* Ensure it's above other content */
  justify-content: center;
  align-items: center;
}

.add-event-wrapper.active {
  display: flex; /* Show modal when active */
}

.add-event-modal {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  width: 90%;
  max-width: 400px;
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
  font-size: 18px;
  color: black;
}

.close:hover {
  color: #555;
}
/* Add more space between cards */
/* Adjust grid layout for 2 columns instead of 3 */
#dashboard.grid {
  grid-template-columns: repeat(2, 1fr) !important; /* Force 2 equal columns */
  gap: 2rem !important;
  width: 100%;
}

/* Make each card wider */
/* #dashboard > div {
  width: 100% !important;
  padding: 2.5rem !important;
  min-height: 240px;
} */

/* For mobile views, ensure one column */
@media (max-width: 768px) {
  #dashboard.grid {
    grid-template-columns: 1fr !important;
  }
}

/* Ensure proper visibility control */
.section.hidden {
  display: none !important;
}

#dashboard > div i.fas {
  margin-bottom: 1.5rem !important; /* mb-6 with !important flag */
}


/* Ensure the patients section content does not stretch */
/* #patients .bg-white.rounded-lg.shadow.p-6 {
  width: 100%;
} */
/* Optional: Adjust the main content padding if needed */

/* Optional: Adjust the grid layout for the dashboard section */
#dashboard {
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}


  </style>

</head>
<body class="bg-gray-100">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar h-screen fixed left-0 top-0 bg-gradient-to-b from-sky-100 to-sky-200 overflow-x-hidden pt-5 transition-all duration-300 border-r border-sky-300 shadow-lg">
      <div class="flex items-center justify-between p-4">
        <h2 class="text-xl font-semibold flex items-center gap-2">
          <i class="fas fa-user-md"></i>
          <span class="sidebar-text">Therapist</span>
        </h2>
        <div id="toggle-button" onclick="toggleSidebar()" class="toggle-button">
          <span class="arrow"></span>
        </div>
      </div>
      <ul class="mt-4">
        <li>
          <a href="#" onclick="showSection('dashboard')" class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 transition-colors">
            <i class="fas fa-home"></i>
            <span class="sidebar-text">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="#" onclick="showSection('calendar')" class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 transition-colors">
            <i class="fas fa-calendar-alt"></i>
            <span class="sidebar-text">  Calendar</span>
          </a>
        </li>
        <li>
          <a href="#" onclick="showSection('patients')" class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 transition-colors">
            <i class="fas fa-users"></i>
            <span class="sidebar-text">Patients</span>
          </a>
        </li>
          <li>
              <a href="{{route('profile.show')}}" class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 transition-colors">
                  <i class="fas fa-user"></i>
                  <span class="sidebar-text">My Profile</span>
              </a>
          </li>
        <!-- Logout Link -->
          <li>
              <form action="/logout" method="POST">
                  @csrf
                  <button type="submit" href="#" class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 transition-colors">
                  <i class="fas fa-sign-out"></i>
                  <span class="sidebar-text">Logout</span>
              </button>
              </form>
          </li>

      </ul>
    </div>

    <div id="main-content" class="main-content flex-1">
    <header class="bg-white shadow">
        <div class="flex justify-between items-center px-6 py-4">
          <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
            <div>
                <x-global-search/>
            </div>
          <div class="flex items-center gap-4">
          <span class="text-gray-600">Welcome, Dr. {{ $doctorName }}</span>            <span id="current-date" class="text-gray-600"></span>
            <button class="text-gray-600 hover:text-gray-800">
              <i class="fas fa-clock"></i>
            </button>
          </div>
        </div>
      </header>

  <main class="p-6">
   <!-- Dashboard Section -->
   <div id="dashboard" class="section grid grid-cols-1 md:grid-cols-2 gap-6">
    <div onclick="showSection('calendar')" class="bg-white rounded-lg shadow p-6 cursor-pointer hover:-translate-y-1 transition-transform">
      <i class="fas fa-calendar-check text-blue-500 text-2xl mb-6"></i>
      <h3 class="text-xl font-semibold mb-2 ">Appointments</h3>
      <p class="text-gray-600">View and manage your appointments.</p>
    </div>
    <div onclick="showSection('patients')" class="bg-white rounded-lg shadow p-6 cursor-pointer hover:-translate-y-1 transition-transform">
      <i class="fas fa-user-clock text-green-500 text-2xl mb-6"></i>
      <h3 class="text-xl font-semibold mb-2">Patients Waiting</h3>
      <p class="text-gray-600">See patients waiting in the waiting room.</p>
    </div>
  </div>


    <!-- Calendar Section -->
    <div id="calendar" class="section hidden">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="calendar-container"></div>
        @include('calendar', ['doctorSpecializations' => $doctorSpecializations ?? []])
      </div>
    </div>

    <!-- Patients Section -->
    <div id="patients" class="section hidden">
      <div class="bg-white rounded-lg shadow p-6">
        <header>
          <h3 class="text-xl font-semibold mb-4">Patients Waiting</h3>
        </header>
        <table class="min-w-full bg-white border-collapse">
          <thead>
            <tr>
              <th class="py-2 border">Child Name</th>
              <th class="py-2 border">Registration Number</th>
              <th class="py-2 border">Visit Date/Time</th>
              <th class="py-2 border">Completed</th>
            </tr>
          </thead>
          <tbody id="patient-table-body">
            <!-- Data will be dynamically populated -->
          </tbody>
        </table>
        <button
          id="startConsultationBtn"
          onclick="startConsultation()"
          class="mt-6 bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition-colors"
        >
          Start Consultation
        </button>
      </div>
    </div>
  </main>
</div>

  <script src="{{ asset('js/loader.js') }}"></script>
  <script>
    let patientQueue = ['Patient A', 'Patient B', 'Patient C'];
    let sidebarExpanded = true;

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const toggleButton = document.getElementById('toggle-button');
      const mainContent = document.getElementById('main-content');

      sidebar.classList.toggle('collapsed');
      toggleButton.classList.toggle('collapsed');
      mainContent.classList.toggle('collapsed');
    }

    function showSection(sectionId) {
      const sections = document.querySelectorAll('.section');
      sections.forEach(section => {
        section.classList.add('hidden');
      });
      document.getElementById(sectionId).classList.remove('hidden');

      if (sectionId === 'calendar') {
        initCalendar(); // Reinitialize calendar
        attachEventListeners();
      } else if (sectionId === 'patients') {
        generatePatientList();
      }

      document.getElementById('appointments-list').classList.add('hidden');
    }

    function updateDateTime() {
      const now = new Date();
      currentDate.textContent = now.toLocaleString();
    }

    /*

    function generateCalendar() {
      const calendarContainer = document.querySelector('.calendar-container');
      const today = new Date();
      const currentMonth = today.getMonth();
      const currentYear = today.getFullYear();

      const firstDay = new Date(currentYear, currentMonth, 1).getDay();
      const daysInMonth = 32 - new Date(currentYear, currentMonth, 32).getDate();

      let tableHtml = '<table class="w-full border-collapse">';
      tableHtml += '<tr class="bg-gray-50"><th class="p-2 border">Sun</th><th class="p-2 border">Mon</th><th class="p-2 border">Tue</th><th class="p-2 border">Wed</th><th class="p-2 border">Thu</th><th class="p-2 border">Fri</th><th class="p-2 border">Sat</th></tr><tr>';

      let date = 1;
      for (let i = 0; i < 6; i++) {
        for (let j = 0; j < 7; j++) {
          if (i === 0 && j < firstDay) {
            tableHtml += '<td class="p-2 border"></td>';
          } else if (date > daysInMonth) {
            tableHtml += '<td class="p-2 border"></td>';
          } else {
            const currentDate = new Date(currentYear, currentMonth, date);
            const formattedDate = currentDate.toLocaleDateString('en-US', {
              month: 'short',
              day: 'numeric'
            });
            tableHtml += `<td class="p-2 border cursor-pointer hover:bg-gray-100" onclick="showAppointments('${formattedDate}')">${formattedDate}</td>`;
            date++;
          }
        }
        if (date > daysInMonth) {
          break;
        } else {
          tableHtml += '</tr><tr>';
        }
      }
      tableHtml += '</tr></table>';
      calendarContainer.innerHTML = tableHtml;
    }*/

    function showAppointments(date) {
      const appointmentsList = document.getElementById('appointments-for-day');
      appointmentsList.innerHTML = `<li class="p-3 bg-gray-50 rounded">No patients booked for ${date}</li>`;
      document.getElementById('appointments-list').classList.remove('hidden');
    }

    function generatePatientList() {
    const patientList = document.querySelector('.patient-list');
    patientList.innerHTML = '';

    children.forEach(child => {
        const listItem = document.createElement('li');
        listItem.className = 'p-4 border rounded hover:bg-gray-50 cursor-pointer transition-colors';
        listItem.innerHTML = `
            <div>
                <p>ID: ${child.id}</p>
                <p>Full Name: ${child.fullname}</p>
                <p>Date of Birth: ${child.dob}</p>
                <p>Birth Certificate: ${child.birth_cert}</p>
                <p>Gender ID: ${child.gender_id}</p>
                <p>Registration Number: ${child.registration_number}</p>
                <p>Created At: ${child.created_at}</p>
                <p>Updated At: ${child.updated_at}</p>
            </div>
        `;
        patientList.appendChild(listItem);
    });
}

function selectPatient(index) {
      const patientListItems = document.querySelectorAll('.patient-list li');
      patientListItems.forEach(item => item.classList.remove('bg-blue-50', 'border-l-4', 'border-blue-500'));
      patientListItems[index].classList.add('bg-blue-50', 'border-l-4', 'border-blue-500');
    }
    let selectedRegistrationNumber = null


function selectRegistrationNumber(registrationNumber, childId) {
  selectedRegistrationNumber = registrationNumber; // Store selected registration number
  console.log(`Selected Registration Number: ${registrationNumber}, Child ID: ${childId}`);

  // Highlight the selected row
  const previouslySelectedRow = document.querySelector('.selected-row');
  if (previouslySelectedRow) {
    previouslySelectedRow.classList.remove('selected-row');
  }

  const selectedRow = document.querySelector(`button[onclick="selectRegistrationNumber('${registrationNumber}', '${childId}')"]`).closest('tr');
  if (selectedRow) {
    selectedRow.classList.add('selected-row');
  }

  // Further actions can be added here, e.g., saving to a variable or performing an API request
}

async function startConsultation() {
    if (!selectedRegistrationNumber) {
        alert('Please select a patient first.');
        return;
    }

    showLoadingIndicator('Starting consultation...', 0);

    // Reset cancellation flag
    window.cancelOperationsFlag = false;

    // Create an AbortController for fetch requests
    const controller = new AbortController();
    const signal = controller.signal;

    // Register this operation so it can be cancelled
    const operationId = 'start-consultation-' + Date.now();
    const cancelCallback = () => {
        controller.abort();
        console.log('Consultation start was cancelled');
    };

    registerRunningFunction(operationId, cancelCallback);

    try {
        // Check if operation was cancelled before proceeding
        if (window.cancelOperationsFlag) {
            throw new Error('Operation cancelled by user');
        }

        // Update loading progress
        updateLoadingProgress(20, 'Checking patient data...');

        // First make an AJAX call to check if the patient exists and get initial data
        const response = await fetch(`/occupationaltherapy_dashboard/${selectedRegistrationNumber}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'  // Marks this as an AJAX request
            },
            signal: signal // Add the abort signal to the fetch request
        });

        // Check if operation was cancelled after the first fetch
        if (window.cancelOperationsFlag) {
            throw new Error('Operation cancelled by user');
        }

        // Update loading progress
        updateLoadingProgress(50, 'Fetching data from server...');

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        // Check if operation was cancelled after parsing JSON
        if (window.cancelOperationsFlag) {
            throw new Error('Operation cancelled by user');
        }

        // Update loading progress
        updateLoadingProgress(80, 'Processing data...');

        // Simulate a bit of processing time
        await new Promise(resolve => {
            const timer = setTimeout(() => {
                window.operationTimers = window.operationTimers.filter(t => t !== timer);
                resolve();
            }, 500);
            window.operationTimers.push(timer);
        });

        // Final cancellation check before redirecting
        if (window.cancelOperationsFlag) {
            throw new Error('Operation cancelled by user');
        }

        updateLoadingProgress(100, 'Complete! Redirecting...');

        // // Hide the indicator before redirecting
        // hideLoadingIndicator();

        // If we successfully got the data, redirect to the dashboard page
        window.location.href = `/occupationaltherapy_dashboard/${selectedRegistrationNumber}`;

    } catch (error) {
        // Check if this was a cancellation
        if (error.name === 'AbortError' || error.message.includes('cancelled')) {
            console.log('Consultation start was cancelled');
            // Don't show an error message for user cancellations
            return;
        }

        console.error('Error starting consultation:', error);
        let errorMessage = 'Error starting consultation. ';

        if (error.message.includes('404')) {
            errorMessage += 'Patient not found.';
        } else if (error.message.includes('403')) {
            errorMessage += 'Access denied.';
        } else {
            errorMessage += 'Please try again or contact support.';
        }

        alert(errorMessage);
    } finally {
        // Clean up
        unregisterRunningFunction(operationId);
    }

}

    showSection('dashboard');
</script>
<!-- <script>
    function generatePatientList() {
      const patientTableBody = document.getElementById("patient-table-body");
      patientTableBody.innerHTML = ""; // Clear existing rows

      // Assuming visits is an array of patient visit objects passed from backend
      const visits = @json($visits); // Use Laravel's Blade directive to pass data

      visits.forEach((visit) => {
        const fullname = JSON.parse(visit.fullname);
        const fullNameString = fullname
          ? `${fullname.first_name} ${fullname.middle_name || ""} ${fullname.last_name}`
          : visit.fullname;

        const row = document.createElement("tr");
        row.innerHTML = `
          <td class="py-2 border">${visit.created_at}</td>
          <td class="py-2 border">${visit.registration_number}</td>
          <td class="py-2 border">${fullNameString}</td>
        `;
        patientTableBody.appendChild(row);
      });
    }

    function showSection(sectionId) {
      const sections = document.querySelectorAll(".section");
      sections.forEach((section) => section.classList.add("hidden"));
      document.getElementById(sectionId).classList.remove("hidden");

      if (sectionId === "patients") {
        generatePatientList(); // Call this when "Patients" section is shown
      }
    }


  </script> -->

  <script>
    // First window.onload handler for handling modal behavior
window.onload = function () {
  const modalWrapper = document.querySelector(".add-event-wrapper");
  if (modalWrapper) {
    modalWrapper.classList.remove("active"); // Ensure the modal is hidden when the page loads
    modalWrapper.style.display = "none"; // Hide the modal initially
  }

  window.handleAddEventModal();
};

// Modal behavior function
window.handleAddEventModal = function () {
  const addEventButton = document.querySelector(".add-event");
  const closeButton = document.querySelector(".close");
  const modalWrapper = document.querySelector(".add-event-wrapper");

  // Open modal on button click
  if (addEventButton && modalWrapper) {
    addEventButton.addEventListener("click", function () {
      console.log("Add event button clicked");
      modalWrapper.style.display = "flex"; // Show the modal
      modalWrapper.classList.add("active"); // Add active class for styling
    });
  }

  // Close modal on close button click
  if (closeButton && modalWrapper) {
    closeButton.addEventListener("click", function () {
      console.log("Close button clicked");
      modalWrapper.style.display = "none"; // Hide the modal
      modalWrapper.classList.remove("active"); // Remove active class
    });
  }

  // Close modal when clicking outside the modal
  window.addEventListener("click", function (event) {
    if (event.target === modalWrapper) {
      modalWrapper.style.display = "none";
      modalWrapper.classList.remove("active");
    }
  });
};

// Second window.onload handler for month/year behavior
window.addEventListener("load", function () {
  // Check if month and year variables are defined (on window)
  if (typeof window.month === "number" && typeof window.year === "number") {
    console.log("Month and year are accessible:", window.month, window.year);
  } else {
    console.warn("Month and year are not defined properly.");
  }

  // Set up navigation button behavior
  if (typeof window.prevMonth === "function" && typeof window.nextMonth === "function") {
    const prevButton = document.querySelector(".prev");
    const nextButton = document.querySelector(".next");

    if (prevButton) {
      prevButton.addEventListener("click", window.prevMonth);
    }

    if (nextButton) {
      nextButton.addEventListener("click", window.nextMonth);
    }
  } else {
    console.warn("prevMonth or nextMonth functions are not defined.");
  }
});

</script>




<script>
  let selectedPatient = null;
  function generatePatientList() {
    const patientTableBody = document.getElementById("patient-table-body");
    patientTableBody.innerHTML = ""; // Clear existing rows

    // Assuming visits is an array of patient visit objects passed from backend
    const visits = @json($visits); // Use Laravel's Blade directive to pass data

    visits.forEach((visit) => {
      const fullname = JSON.parse(visit.fullname);
      const fullNameString = fullname
        ? `${fullname.first_name} ${fullname.middle_name || ""} ${fullname.last_name}`
        : visit.fullname;

      const row = document.createElement("tr");
      row.innerHTML = `
        <td class="py-2 border">${fullNameString}</td>
        <td class="py-2 border">${visit.registration_number}</td>
        <td class="py-2 border">${visit.created_at}</td>
        <td class="py-2 border">${visit.completed ? "&#10004;" : "&#10008;"}</td>
        <td class="py-2 border">
          <button class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600"
            onclick="selectRegistrationNumber('${visit.registration_number}', '${visit.child_id}', this)">
            Select
          </button>
        </td>
      `;
      patientTableBody.appendChild(row);
    });
  }

  function selectRegistrationNumber(registrationNumber, childId, button) {
    if (selectedRegistrationNumber === registrationNumber) {
      // Unselect the patient
      selectedRegistrationNumber = null;
      button.textContent = 'Select';
      button.classList.remove('bg-red-500', 'hover:bg-red-600');
      button.classList.add('bg-blue-500', 'hover:bg-blue-600');
    } else {
      // Select the patient
      selectedRegistrationNumber = registrationNumber;
      button.textContent = 'Unselect';
      button.classList.remove('bg-blue-500', 'hover:bg-blue-600');
      button.classList.add('bg-red-500', 'hover:bg-red-600');
    }

    // Highlight the selected row
    const previouslySelectedRow = document.querySelector('.selected-row');
    if (previouslySelectedRow) {
      previouslySelectedRow.classList.remove('selected-row');
      const previousButton = previouslySelectedRow.querySelector('button');
      previousButton.textContent = 'Select';
      previousButton.classList.remove('bg-red-500', 'hover:bg-red-600');
      previousButton.classList.add('bg-blue-500', 'hover:bg-blue-600');
    }

    const selectedRow = button.closest('tr');
    if (selectedRow) {
      selectedRow.classList.toggle('selected-row');
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    generatePatientList();
  });
</script>
<script>
  function updateDateTime() {
  const now = new Date();
  const currentDate = document.getElementById('current-date');
  currentDate.textContent = now.toLocaleString();
}

document.addEventListener('DOMContentLoaded', () => {
  updateDateTime();
  setInterval(updateDateTime, 1000);
});
</script>



</body>
</html>
<!-- therapistsDashboard.blade.php -->
