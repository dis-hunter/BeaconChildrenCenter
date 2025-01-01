<!DOCTYPE html>
<html>
<head>
  <title>Therapist Dashboard</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
    }

    .sidebar {
      width: 250px;
      background-color: #f0f0f0;
      position: fixed;
      height: 100%;
      overflow-y: auto;
    }

    .sidebar h2 {
      padding: 10px;
      margin: 0;
      text-align: center;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar li {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }

    .sidebar a {
      display: block;
      text-decoration: none;
      color: #333;
    }

    .main-content {
      margin-left: 250px;
      padding: 20px;
    }

    .header {
      background-color: #fff;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #ddd;
    }

    .header h1 {
      margin: 0;
    }

    .content {
      margin-top: 20px;
    }

    .dashboard-card {
      flex: 0 0 calc(33.33% - 20px);
      background-color: #fff;
      border: 1px solid #ddd;
      padding: 20px;
      margin-bottom: 20px;
      box-sizing: border-box;
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .calendar-container {
      width: 80%;
      margin: 20px auto;
      border: 1px solid #ddd;
    }

    .calendar {
      display: none;
    }

    .calendar table {
      width: 100%;
      border-collapse: collapse;
    }

    .calendar td,
    .calendar th {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
      cursor: pointer;
    }

    .calendar .current-day {
      background-color: #f0f0f0;
    }

    .patient-list-container {
      display: none;
    }

    .patient-list {
      list-style: none;
      padding: 0;
    }

    .patient-list li {
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer; /* Make patient list items clickable */
    }

    .patient-list li.active {
      background-color: #f0f0f0;
      border-left: 4px solid #007bff;
    }

    .icon {
      margin-right: 5px;
    }

    .appointments-list {
      display: none;
      margin-top: 20px;
    }

    .appointments-list ul {
      list-style: none;
      padding: 0;
    }

    .appointments-list li {
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 5px;
    }
    .patient-list li {
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
      background-color: #fff; /* Add a white background */
      transition: background-color 0.3s ease; /* Smooth transition for hover effect */
    }

    .patient-list li:hover {
      background-color: #f5f5f5; /* Light gray background on hover */
    }

    .patient-list li.active {
      background-color: #e9ecef; /* Lighter gray for active patient */
      border-left: 4px solid #007bff;
    }

    #startConsultationBtn {
      background-color: #007bff; /* Blue background for the button */
      color: white;
      border: none;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin-top: 10px; 
      border-radius: 5px; /* Add rounded corners */
      cursor: pointer;
    }

    #startConsultationBtn:hover {
      background-color: #0056b3; /* Darker blue on hover */
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <div class="sidebar">
    <h2><i class="fas fa-user-md icon"></i> Therapist</h2>
    <ul>
      <li><a href="#" onclick="showSection('dashboard')"><i class="fas fa-home icon"></i> Dashboard</a></li>
      <li><a href="#" onclick="showSection('calendar')"><i class="fas fa-calendar-alt icon"></i> Calendar</a></li>
      <li><a href="#" onclick="showSection('patients')"><i class="fas fa-users icon"></i> Patients</a></li>
    </ul>
  </div>

  <div class="main-content">
    <div class="header">
      <h1>Dashboard</h1>
      <div class="user-info">
        <span>Welcome, Dr. [Name]</span>
        <span id="current-date"></span>
        <i class="fas fa-bell icon"></i>
      </div>
    </div>

    <div class="content">
      <div id="dashboard" class="section">
        <div class="dashboard-card" onclick="showSection('calendar')">
          <i class="fas fa-calendar-check icon"></i>
          <h3>Appointments</h3>
          <p>View and manage your appointments.</p>
        </div>
        <div class="dashboard-card" onclick="showSection('patients')">
          <i class="fas fa-user-clock icon"></i>
          <h3>Patients Waiting</h3>
          <p>See patients waiting in the waiting room.</p>
        </div>
        <div class="dashboard-card">
          <i class="fas fa-tasks icon"></i>
          <h3>Tasks/Reminders</h3>
          <p>Manage your tasks and reminders.</p>
        </div>
      </div>

      <div id="calendar" class="section calendar">
        <div class="calendar-container"></div>
        <div id="appointments-list" class="appointments-list">
          <ul id="appointments-for-day"></ul>
        </div>
      </div>

      <div id="patients" class="section patient-list-container">
        <h3>Patients Waiting</h3>
        <ul class="patient-list"></ul>
        <button id="startConsultationBtn" onclick="startConsultation()">Start Consultation</button>
      </div>
    </div>
  </div>

  <script>
    let patientQueue = ['Patient A', 'Patient B', 'Patient C']; // Sample queue

    function showSection(sectionId) {
      const sections = document.querySelectorAll('.section');
      sections.forEach(section => {
        section.style.display = 'none';
      });
      document.getElementById(sectionId).style.display = 'block';

      if (sectionId === 'calendar') {
        generateCalendar();
      } else if (sectionId === 'patients') {
        generatePatientList();
      }

      // Hide the appointments list when switching sections
      document.getElementById('appointments-list').style.display = 'none';
    }

    function updateDateTime() {
      const now = new Date();
      currentDate.textContent = now.toLocaleString();
    }
    setInterval(updateDateTime, 1000);

    function generateCalendar() {
      const calendarContainer = document.querySelector('.calendar-container');
      const today = new Date();
      const currentMonth = today.getMonth();
      const currentYear = today.getFullYear();

      const firstDay = (new Date(currentYear, currentMonth)).getDay();
      const daysInMonth = 32 - new Date(currentYear, currentMonth, 32).getDate();

      let tableHtml = '<table>';
      tableHtml += '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr><tr>';

      let date = 1;
      for (let i = 0; i < 6; i++) {
        for (let j = 0; j < 7; j++) {
          if (i === 0 && j < firstDay) {
            tableHtml += '<td></td>';
          } else if (date > daysInMonth) {
            tableHtml += '<td></td>';
          } else {
            const currentDate = new Date(currentYear, currentMonth, date);
            const formattedDate = currentDate.toLocaleDateString('en-US', {
              month: 'short',
              day: 'numeric'
            });
            tableHtml += <td onclick="showAppointments('${formattedDate}')">${formattedDate}</td>;
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
      appointmentsList.innerHTML = <li>No patients booked for ${date}</li>;
      document.getElementById('appointments-list').style.display = 'block';
    }

    function generatePatientList() {
      const patientList = document.querySelector('.patient-list');
      patientList.innerHTML = ''; // Clear the list

      for (let i = 0; i < patientQueue.length; i++) {
        const patientItem = document.createElement('li');
        patientItem.textContent = patientQueue[i];
        patientItem.addEventListener('click', () => selectPatient(i));
        patientList.appendChild(patientItem);
      }
    }

    function selectPatient(index) {
      const patientListItems = document.querySelectorAll('.patient-list li');
      patientListItems.forEach(item => item.classList.remove('active'));
      patientListItems[index].classList.add('active');
    }

    function startConsultation() {
      const activePatient = document.querySelector('.patient-list li.active');
      if (activePatient) {
        console.log('Starting consultation with:', activePatient.textContent);
        // Implement your consultation logic here
      } else {
        alert('Please select a patient first.');
      }
    }

    showSection('dashboard');

    const currentDate = document.getElementById('current-date');
    updateDateTime();
  </script>
</body>
</html><?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/therapists/therapistsDashboard.blade.php ENDPATH**/ ?>