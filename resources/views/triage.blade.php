<!DOCTYPE html>
<html>
<head>
  <title>Health Assessment Form</title>
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
    .sidebar h2  {
      padding: 6px 0px 0px 16px;
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
  </style>
</head>
<body>

  <div class="sidebar">
    <!-- <a href="#triage">Triage Examination</a> -->
    <h2>Triage Examination</h2>
    <h2>Active Patient:</h2>
    <h3 id="patient-name" style="text-align: center; margin-bottom: 20px;"></h3>

    <!-- <a href="#">Patient Records</a>
    <a href="#">Appointments</a>
    <a href="#">Reports</a> -->
    <div class="logout">Logout</div>
  </div>

  <div class="main">
    <h2>Health Assessment Form</h2>
    <div id="triage" class="form-section">
      <h3>Enter Patient Details</h3>
      <form>
        <!-- Add Triage Priority Select -->
        <label for="triage_priority">Triage Priority:</label>
        <select id="triage_priority" required>
          <option value="">Select Priority</option>
          <option value="emergency">Emergency</option>
          <option value="priority">Priority</option>
          <option value="routine">Routine</option>
        </select>

        <!-- Add Triage Sorting Select -->
        <label for="triage_sorting">Department Referral:</label>
        <select id="triage_sorting" required>
          <option value="">Select Department</option>
          <option value="general">General Doctor</option>
          <option value="occupational">Occupational Therapist</option>
          <option value="speech">Speech Therapist</option>
          <option value="physio">Physiotherapist</option>
        </select>

        <label for="temperature">Temperature (°C):</label>
        <input type="number" id="temperature" placeholder="Enter temperature">

        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" placeholder="Enter weight">

        <label for="height">Height (m):</label>
        <input type="number" id="height" step="0.01" placeholder="Enter height">

        <label for="head_circumference">Head Circumference (cm):</label>
        <input type="number" id="head_circumference" step="0.01" placeholder="Enter head circumference">

        <label for="blood_pressure">Blood Pressure:</label>
        <input type="text" id="blood_pressure" placeholder="e.g., 120/80">

        <label for="pulse_rate">Pulse Rate (bpm):</label>
        <input type="number" id="pulse_rate" placeholder="Enter pulse rate">

        <label for="respiratory_rate">Respiratory Rate (breaths/min):</label>
        <input type="number" id="respiratory_rate" placeholder="Enter respiratory rate">

        <label for="oxygen_saturation">Oxygen Saturation (%):</label>
        <input type="number" id="oxygen_saturation" placeholder="Enter oxygen saturation">

        <label for="MUAC">MUAC (cm):</label>
        <input type="number" id="MUAC" step="0.1" placeholder="Enter MUAC">

        <button type="submit">Submit</button>
      </form>
    </div>
  </div>
</body>
<script src="{{ asset('js/triage.js') }}">
  
  document.addEventListener('DOMContentLoaded', () => {
    function getChildIdFromUrl() {
    const pathParts = window.location.pathname.split('/');
    return pathParts[pathParts.length - 1];
}
});
</script>
</html>
