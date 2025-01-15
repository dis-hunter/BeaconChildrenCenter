<!DOCTYPE html>
<html>
<head>
  <title>Health Assessment Form</title>
  <style>
  body {
  margin: 0;
  font-family: sans-serif;
  font-size: 14px;
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

.sidebar a,
.sidebar h2 {
  font-size: 14px;
  padding: 4px 8px;
}

.sidebar h3 {
  font-size: 16px;
  text-align: center;
  margin-bottom: 15px;
}

.logout {
  font-size: 14px;
  padding: 5px 8px;
}

.main {
  margin-left: 200px;
  padding: 15px;
  width: 50%; /* Restrict the width to half the page */
  box-sizing: border-box; /* Ensure padding is included within the width */
}

.form-section {
  margin-bottom: 15px;
  border: 1px solid #ddd;
  padding: 10px;
  background-color: #f9f9f9;
  font-size: 14px;
  width: 100%; /* Make it occupy the full width of the container */
  box-sizing: border-box; /* Prevent padding from affecting width */
}

.form-section h3 {
  font-size: 16px;
  margin-top: 0;
}

.form-section input,
.form-section select,
.form-section button {
  font-size: 13px;
  padding: 6px;
  margin: 4px 0;
  width: calc(50% - 12px); /* Adjust input fields to fit neatly */
  display: inline-block; /* Arrange inputs side by side */
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

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
      <form id="triage-form">
    <label for="triage_priority">Triage Priority:</label>
    <select id="triage_priority" name="triage_priority" required>
        <option value="">Select Priority</option>
        <option value="emergency">Emergency</option>
        <option value="priority">Priority</option>
        <option value="routine">Routine</option>
    </select>

<br>
    <label for="temperature">Temperature (°C):</label>
    <input type="number" name="temperature" required>

    <label for="weight">Weight (kg):</label>
    <input type="number" name="weight" required>

    <label for="height">Height (m):</label>
    <input type="number" name="height" step="0.01" required>

    <label for="head_circumference">Head Circumference (cm):</label>
    <input type="number" name="head_circumference" step="0.01" required>

    <label for="blood_pressure">Blood Pressure:</label>
    <input type="text" name="blood_pressure" required>

    <label for="pulse_rate">Pulse Rate (bpm):</label>
    <input type="number" name="pulse_rate" required>

    <label for="respiratory_rate">Respiratory Rate (breaths/min):</label>
    <input type="number" name="respiratory_rate" required>

    <label for="oxygen_saturation">Oxygen Saturation (%):</label>
    <input type="number" name="oxygen_saturation" required>

    <label for="muac">MUAC (cm):</label>
    <input type="number" name="muac" step="0.1" required>

    <button type="submit">Submit</button>
</form>

    </div>
  </div>
</body>
<script src="<?php echo e(asset('js/triage.js')); ?>">
  
  document.addEventListener('DOMContentLoaded', () => {
    function getChildIdFromUrl() {
    const pathParts = window.location.pathname.split('/');
    return pathParts[pathParts.length - 1];
}
});
</script>
</html>
<?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/triage.blade.php ENDPATH**/ ?>