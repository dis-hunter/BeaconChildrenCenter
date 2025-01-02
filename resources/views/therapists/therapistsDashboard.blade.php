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
        <button id="toggle-button" onclick="toggleSidebar()" class="text-white hover:text-gray-300">
          <i class="fas fa-bars"></i>
        </button>
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
    <div class="flex-1">
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
        <div id="patients" class="section hidden">
          <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-semibold mb-4">Patients Waiting</h3>
            <ul class="patient-list space-y-2"></ul>
            <button id="startConsultationBtn" onclick="startConsultation()" class="mt-6 bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition-colors">
              Start Consultation
            </button>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script>
    let patientQueue = ['Patient A', 'Patient B', 'Patient C'];
    let sidebarExpanded = true;

    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const sidebarTexts = document.querySelectorAll('.sidebar-text');
      const toggleButton = document.getElementById('toggle-button');
      
      sidebarExpanded = !sidebarExpanded;
      
      if (sidebarExpanded) {
        sidebar.classList.remove('collapsed');
        toggleButton.classList.remove('collapsed');
        sidebarTexts.forEach(text => text.style.display = 'inline');
      } else {
        sidebar.classList.add('collapsed');
        toggleButton.classList.add('collapsed');
        sidebarTexts.forEach(text => text.style.display = 'none');
      }
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

      patientQueue.forEach((patient, index) => {
        const patientItem = document.createElement('li');
        patientItem.className = 'p-4 border rounded hover:bg-gray-50 cursor-pointer transition-colors';
        patientItem.textContent = patient;
        patientItem.addEventListener('click', () => selectPatient(index));
        patientList.appendChild(patientItem);
      });
    }

    function selectPatient(index) {
      const patientListItems = document.querySelectorAll('.patient-list li');
      patientListItems.forEach(item => item.classList.remove('bg-blue-50', 'border-l-4', 'border-blue-500'));
      patientListItems[index].classList.add('bg-blue-50', 'border-l-4', 'border-blue-500');
    }

    function startConsultation() {
      const activePatient = document.querySelector('.patient-list li.border-blue-500');
      if (activePatient) {
        console.log('Starting consultation with:', activePatient.textContent);
      } else {
        alert('Please select a patient first.');
      }
    }

    showSection('dashboard');
    
    const currentDate = document.getElementById('current-date');
    updateDateTime();
    setInterval(updateDateTime, 1000);
  </script>
</body>
</html>
