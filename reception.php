<!DOCTYPE html>
<html>
<head>
  <title>Reception Interface</title>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
    }

    .sidebar {
      height: 100%;
      width: 200px;
      position: fixed;
      left: 0;
      top: 0;
      background-color: #f1f1f1;
      overflow-x: hidden;
      padding-top: 20px;
    }

    .sidebar a {
      padding: 6px 8px 6px 16px;
      text-decoration: none;
      font-size: 18px;
      color: #333;
      display: block;
    }

    .sidebar a:hover {
      background-color: #ddd;
    }

    .logout {
      padding: 6px 8px 6px 16px;
      text-decoration: none;
      font-size: 18px;
      color: white;
      background-color: #ff4d4d;
      display: block;
      text-align: center;
      margin-bottom: 20px;
      cursor: pointer;
    }

    .logout:hover {
      background-color: #ff1a1a;
    }

    .main {
      margin-left: 200px;
      padding: 20px;
    }

    .form-section {
      margin-bottom: 20px;
      border: 1px solid #ddd;
      padding: 15px;
      background-color: #f9f9f9;
    }

    .form-section h3 {
      margin-top: 0;
    }

    .form-section input, .form-section select, .form-section button {
      margin: 5px 0;
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }

    .form-section button {
      background-color: #add8e6;
      border: 1px solid #ccc;
      color: #333;
    }

    .form-section button:hover {
      background-color: #87ceeb;
    }

    .calendar {
      border: 1px solid #ddd;
      padding: 10px;
      background-color: #fff;
    }

    .calendar h3 {
      margin-top: 0;
    }

    .calendar .slot {
      margin: 5px 0;
      padding: 5px;
      border: 1px solid #ccc;
      text-align: center;
      cursor: pointer;
    }

    .calendar .slot:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <div class="logout">Logout</div>
  <a href="#patientRegistration">Patient Registration</a>
  <!-- <button id="bookAppointmentButton">Book Appointment</button> -->
  <a href="#appointmentManagement">Appointment Management</a>
  <a href="#calendar">Calendar</a>
  <a href="#payment">Payments</a>
  <a href="#records">Patient Records</a>
</div>

<div class="main">
  <h2>Reception Dashboard</h2>

  <div id="patientRegistration" class="form-section">
    <h3>Patient Registration</h3>
    <input type="text" placeholder="Full Name">
    <input type="date" placeholder="Date of Birth">
    <input type="text" placeholder="Age">
    <input type="text" placeholder="Parents' Contact">
    <input type="email" placeholder="Email Address">
    <select>
      <option>Self</option>
      <option>Referring Doctor</option>
      <option>School Referral</option>
    </select>
    <select>
      <option>Booked Client</option>
      <option>Walk-in</option>
      <option>Emergency</option>
    </select>
    <button>Register Patient</button>
  </div>

  <div id="appointmentManagement" class="form-section">
    
    <h3>Appointment Management</h3>
    <input type="datetime-local" placeholder="Appointment Date & Time">
    <select>
      <option>Booked Client</option>
      <option>Walk-in</option>
      <option>Emergency</option>
    </select>
    <button>Book Appointment</button>
  </div>

  <div id="calendar" class="calendar">
    <h3>Available Slots</h3>
    <div class="slot">09:00 AM - Available</div>
    <div class="slot">10:00 AM - Available</div>
    <div class="slot">11:00 AM - Fully Booked</div>
  </div>

  <div id="payment" class="form-section">
    <h3>Payments</h3>
    <select>
      <option>Insurance</option>
      <option>NCPD</option>
      <option>Cash</option>
    </select>
    <input type="text" placeholder="Amount">
    <button>Process Payment</button>
  </div>

  <div id="records" class="form-section">
    <h3>Patient Records</h3>
    <button>View Records</button>
    <button>Update Records</button>
  </div>
</div>

<script>
  document.querySelector('.logout').addEventListener('click', function() {
    alert('You have been logged out.');
    window.location.href = '/login'; // Redirect to login page
  });
</script>

</body>
</html>

<h1 class="page-title">Doctor's Details</h1>
    
    <div class="search-bar">
        <input type="text" placeholder="Search Doctor Name" class="search-input">
        <form action="{{ route('doctor.form') }}" method="GET">
            <button type="submit" class="add-button">
                <span>+</span>
                Add Doctor
            </button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialisation</th>
                <th>Staff ID</th>
                <th>Calendar</th>
            </tr>
        </thead>
        <tbody id="progressTableBody">
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td><span class="specialty-badge specialty-cardiology">Cardiology</span></td>
                <td>1</td>
                <td>📅</td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td><span class="specialty-badge specialty-neurology">Neurology</span></td>
                <td>1</td>
                <td>📅</td>
            </tr>
        </tbody>
    </table>