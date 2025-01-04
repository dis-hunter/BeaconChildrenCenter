<!DOCTYPE html>
<html>
<head>
  <title>Therapist Dashboard</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .sidebar {
      width: 200px;
      transition: width 0.3s ease;
    }

    .sidebar.collapsed {
      width: 60px;
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
      left: 60px;
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
            <span class="sidebar-text">Calendar</span>
          </a>
        </li>
        <li>
          <a href="#" onclick="showSection('patients')" class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 transition-colors">
            <i class="fas fa-users"></i>
            <span class="sidebar-text">Patients</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="main-content flex-1">
      <header class="bg-white shadow">
        <div class="flex justify-between items-center px-6 py-4">
          <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
          <div class="flex items-center gap-4">
            <span class="text-gray-600">Welcome, Dr. [Name]</span>
            <span id="current-date" class="text-gray-600"></span>
            <button class="text-gray-600 hover:text-gray-800">
              <i class="fas fa-bell"></i>
            </button>
          </div>
        </div>
      </header>

      <main class="p-6">
        <!-- Dashboard Section -->
        <div id="dashboard" class="section grid grid-cols-1 md:grid-cols-3 gap-6">
          <div onclick="showSection('calendar')" class="bg-white rounded-lg shadow p-6 cursor-pointer hover:-translate-y-1 transition-transform">
            <i class="fas fa-calendar-check text-blue-500 text-2xl mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Appointments</h3>
            <p class="text-gray-600">View and manage your appointments.</p>
          </div>
          <div onclick="showSection('patients')" class="bg-white rounded-lg shadow p-6 cursor-pointer hover:-translate-y-1 transition-transform">
            <i class="fas fa-user-clock text-green-500 text-2xl mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Patients Waiting</h3>
            <p class="text-gray-600">See patients waiting in the waiting room.</p>
          </div>
          <div class="bg-white rounded-lg shadow p-6 cursor-pointer hover:-translate-y-1 transition-transform">
            <i class="fas fa-tasks text-purple-500 text-2xl mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Tasks/Reminders</h3>
            <p class="text-gray-600">Manage your tasks and reminders.</p>
          </div>
        </div>

        <!-- Calendar Section -->
        <div id="calendar" class="section hidden">
          <div class="bg-white rounded-lg shadow p-6">
            <div class="calendar-container"></div>
            <div id="appointments-list" class="mt-6 hidden">
              <ul id="appointments-for-day" class="space-y-2"></ul>
            </div>
          </div>
        </div>

       <!-- Patients Section -->
      <section id="patients" class="section hidden">
        <div class="bg-white rounded-lg shadow p-6">
          <header>
            <h3 class="text-xl font-semibold mb-4">Patients Waiting</h3>
          </header>
          <table class="min-w-full bg-white border-collapse">
            <thead>
              <tr>
                <th class="py-2 border">Visit ID</th>
                <th class="py-2 border">Visit Date</th>
                <th class="py-2 border">Visit Time</th>
                <th class="py-2 border">Registration Number</th>
                <th class="py-2 border">Child ID</th>
                <th class="py-2 border">Child Name</th>
                <th class="py-2 border">Child DOB</th>
                <th class="py-2 border">Staff ID</th>
                <th class="py-2 border">Specialization</th>
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
      </section>
    </main>
  </div>
      </main>
    </div>
  </div>

 
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
        generateCalendar();
      } else if (sectionId === 'patients') {
        generatePatientList();
      }

      document.getElementById('appointments-list').classList.add('hidden');
    }

    function updateDateTime() {
      const now = new Date();
      currentDate.textContent = now.toLocaleString();
    }

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
    }

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
  alert(`Selected Registration Number: ${registrationNumber}, Child ID: ${childId}`);
  
  
  
  // Further actions can be added here, e.g., saving to a variable or performing an API request
}

async function startConsultation() {
    if (!selectedRegistrationNumber) {
        alert('Please select a patient first.');
        return;
    }

    try {
        // First make an AJAX call to check if the patient exists and get initial data
        const response = await fetch(`http://127.0.0.1:8000/occupationaltherapy_dashboard/${selectedRegistrationNumber}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'  // Marks this as an AJAX request
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        
        // If we successfully got the data, redirect to the dashboard page
        window.location.href = `/occupationaltherapy_dashboard/${selectedRegistrationNumber}`;

    } catch (error) {
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
    }
} 
    showSection('dashboard');
    
    const currentDate = document.getElementById('current-date');
    updateDateTime();
    setInterval(updateDateTime, 1000);
  </script>
  <script>
    function showAppointments(date) {
        const appointmentsList = document.getElementById('appointments-for-day');
        appointmentsList.innerHTML = `<li class="p-3 bg-gray-50 rounded">No patients booked for ${date}</li>`;
        document.getElementById('appointments-list').classList.remove('hidden');
    }

    function showSection(sectionId) {
        const sections = document.querySelectorAll('.section');
        sections.forEach(section => {
            section.classList.add('hidden');
        });
        document.getElementById(sectionId).classList.remove('hidden');

        if (sectionId === 'calendar') {
            generateCalendar();
        } else if (sectionId === 'patients') {
            generatePatientList();
        }

        document.getElementById('appointments-list').classList.add('hidden');
    }

    showSection('dashboard');
</script>
<script>
    function generatePatientList() {
      const patientTableBody = document.getElementById("patient-table-body");
      patientTableBody.innerHTML = ""; // Clear existing rows

      // Assuming visits is an array of patient visit objects passed from backend
      const visits = <?php echo json_encode($visits, 15, 512) ?>; // Use Laravel's Blade directive to pass data

      visits.forEach((visit) => {
        const fullname = JSON.parse(visit.fullname);
        const fullNameString = fullname
          ? `${fullname.first_name} ${fullname.middle_name || ""} ${fullname.last_name}`
          : visit.fullname;

        const row = document.createElement("tr");
        row.innerHTML = `
          <td class="py-2 border">${visit.visit_id}</td>
          <td class="py-2 border">${visit.visit_date}</td>
          <td class="py-2 border">${visit.created_at}</td>
          <td class="py-2 border">${visit.registration_number}</td>
          <td class="py-2 border">${visit.child_id}</td>
          <td class="py-2 border">${fullNameString}</td>
          <td class="py-2 border">${visit.dob}</td>
          <td class="py-2 border">${visit.staff_id}</td>
          <td class="py-2 border">${visit.specialization_id}</td>
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

   
  </script>
<script>
  let selectedPatient = null;

  function generatePatientList() {
  const patientTableBody = document.getElementById("patient-table-body");
  patientTableBody.innerHTML = ""; // Clear existing rows

  // Assuming visits is an array of patient visit objects passed from backend
  const visits = <?php echo json_encode($visits, 15, 512) ?>; // Use Laravel's Blade directive to pass data

  visits.forEach((visit) => {
    const fullname = JSON.parse(visit.fullname);
    const fullNameString = fullname
      ? `${fullname.first_name} ${fullname.middle_name || ""} ${fullname.last_name}`
      : visit.fullname;

    const row = document.createElement("tr");
    row.innerHTML = `
      <td class="py-2 border">${visit.visit_id}</td>
      <td class="py-2 border">${visit.visit_date}</td>
      <td class="py-2 border">${visit.created_at}</td>
      <td class="py-2 border">${visit.registration_number}</td>
      <td class="py-2 border">${visit.child_id}</td>
      <td class="py-2 border">${fullNameString}</td>
      <td class="py-2 border">${visit.dob}</td>
      <td class="py-2 border">${visit.staff_id}</td>
      <td class="py-2 border">${visit.specialization_id}</td>
      <td class="py-2 border">
       <button class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600" 
        onclick="selectRegistrationNumber('${visit.registration_number}', '${visit.child_id}')">
  Select
</button>

      </td>
    `;
    patientTableBody.appendChild(row);
  });
}



  function selectPatient(patient) {
    selectedPatient = patient;
    const patientTableBody = document.getElementById("patient-table-body");
    const rows = patientTableBody.querySelectorAll("tr");
    rows.forEach(row => row.classList.remove("bg-blue-50", "border-l-4", "border-blue-500"));
    event.currentTarget.classList.add("bg-blue-50", "border-l-4", "border-blue-500");
  }

 

  document.addEventListener('DOMContentLoaded', () => {
    generatePatientList();
  });
</script>
</body>
</html>
<?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/therapists/therapistsDashboard.blade.php ENDPATH**/ ?>