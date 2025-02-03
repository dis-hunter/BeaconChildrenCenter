<!DOCTYPE html>
<html>
<head>
  <title>Health Assessment Form</title>
  <style>
    :root {
      --primary-blue: #4285f4;
      --text-color: #333;
      --background-gray: #f8f9fa;
      --sidebar-width: 250px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    body {
      background-color: var(--background-gray);
    }

    .top-bar {
      background-color: var(--primary-blue);
      color: white;
      padding: 1rem 2rem;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 100;
    }

    .sidebar {
      height: 100vh;
      width: var(--sidebar-width);
      position: fixed;
      left: 0;
      top: 0;
      background-color: white;
      padding-top: 80px;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar-item {
      padding: 0.8rem 1.5rem;
      display: flex;
      align-items: center;
      color: var(--text-color);
      text-decoration: none;
      transition: background-color 0.2s;
    }

    .sidebar-item:hover {
      background-color: #e8eaf6;
    }

    .sidebar-item.active {
      background-color: #e3f2fd;
      color: var(--primary-blue);
    }

    .main-content {
      margin-left: var(--sidebar-width);
      padding: 1.5rem;
      padding-top: 70px;
      max-width: 1200px;
    }

    .card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 1.2rem;
      margin-bottom: 1rem;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 0.8rem;
    }

    .form-group {
      margin-bottom: 0.8rem;
    }

    label {
      display: block;
      margin-bottom: 0.3rem;
      color: #666;
      font-size: 0.85rem;
    }

    input, select {
      width: 100%;
      padding: 0.4rem;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 0.9rem;
    }

    input:focus, select:focus {
      outline: none;
      border-color: var(--primary-blue);
      box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.1);
    }

    .btn-primary {
      background-color: var(--primary-blue);
      color: white;
      padding: 0.5rem 1.2rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.9rem;
      transition: background-color 0.2s;
    }

    .btn-outline {
      background-color: transparent;
      color: var(--primary-blue);
      padding: 0.5rem 1rem;
      border: 1px solid var(--primary-blue);
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.9rem;
      transition: all 0.2s;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 1rem;
    }

    .btn-outline:hover {
      background-color: #e3f2fd;
    }

    .btn-primary:hover {
      background-color: #3367d6;
    }

    .patient-info {
      background-color: #e3f2fd;
      padding: 1rem;
      border-radius: 4px;
      margin-bottom: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #patient-name {
      font-size: 1.1rem;
      color: var(--primary-blue);
      margin: 0;
    }

    .form-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.2rem;
    }

    h2 {
      font-size: 1.3rem;
    }
    /* Alert System */
#alert-container {
  position: fixed;
  top: 100px;
  right: 20px;
  z-index: 1000;
  max-width: 400px;
}

.alert {
  padding: 15px 20px;
  margin-bottom: 1rem;
  border-radius: 6px;
  display: flex;
  align-items: center;
  background: white;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
  from { transform: translateX(100%); }
  to { transform: translateX(0); }
}

.alert.error {
  border-left: 4px solid #dc3545;
}

.alert.success {
  border-left: 4px solid #28a745;
}

.alert-icon {
  font-size: 1.4rem;
  margin-right: 12px;
}

.alert-text {
  flex-grow: 1;
  font-size: 0.95rem;
  white-space: pre-wrap;
}

.alert-close {
  margin-left: 15px;
  cursor: pointer;
  opacity: 0.7;
  transition: opacity 0.2s;
}

.alert-close:hover {
  opacity: 1;
}

/* Error highlighting */
.form-group.error label {
  color: #dc3545;
}

.form-group.error input,
.form-group.error select {
  border-color: #dc3545;
  background-color: #fff8f8;
}
  </style>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body>
  <div class="top-bar">
    <span>Nurse</span>
  </div>

  <div class="sidebar">
  <a href="<?php echo e(route('triage.dashboard')); ?>" class="sidebar-item">
      Dashboard
    </a>
    <a href="#" class="sidebar-item">
      Profile
    </a>
    <a href="#" class="sidebar-item">
      Booked Patients
    </a>
    <a href="#" class="sidebar-item">
      Therapy List
    </a>
    <a href="#" class="sidebar-item active">
      Triage
    </a>
  </div>

  <div class="main-content">
    <div class="patient-info">
      <h2 id="patient-name">Patient Name</h2>
      <a href="<?php echo e(route('triage.dashboard')); ?>" class="btn-outline">&larr; Back to Dashboard</a>
    </div>
    <div id="alert-container"></div>
    <div class="card">
      <div class="form-header">
        <h2>Health Assessment Form</h2>
      </div>
      
      <form id="triage-form">
        <div class="form-grid">
          <!-- Triage Priority moved to top -->
          <div class="form-group" style="grid-column: span 3">
            <label for="triage_priority">Triage Priority</label>
            <select id="triage_priority" name="triage_priority" required>
              <option value="">Select Priority</option>
              <option value="emergency">Emergency</option>
              <option value="priority">Priority</option>
              <option value="routine">Routine</option>
            </select>
          </div>

          <!-- All other form fields remain but in 3-column grid -->
          <div class="form-group">
            <label for="temperature">Temperature (°C)</label>
            <input type="number" name="temperature" required>
          </div>

          <div class="form-group">
            <label for="weight">Weight (kg)</label>
            <input type="number" name="weight" required>
          </div>

          <div class="form-group">
            <label for="height">Height (m)</label>
            <input type="number" name="height" step="0.01" required>
          </div>

          <div class="form-group">
            <label for="head_circumference">Head Circumference (cm)</label>
            <input type="number" name="head_circumference" step="0.01" required>
          </div>

          <div class="form-group">
            <label for="blood_pressure">Blood Pressure</label>
            <input type="text" name="blood_pressure" required>
          </div>

          <div class="form-group">
            <label for="pulse_rate">Pulse Rate (bpm)</label>
            <input type="number" name="pulse_rate" required>
          </div>

          <div class="form-group">
            <label for="respiratory_rate">Respiratory Rate (breaths/min)</label>
            <input type="number" name="respiratory_rate" required>
          </div>

          <div class="form-group">
            <label for="oxygen_saturation">Oxygen Saturation (%)</label>
            <input type="number" name="oxygen_saturation" required>
          </div>

          <div class="form-group">
            <label for="muac">MUAC (cm)</label>
            <input type="number" name="muac" step="0.1" required>
          </div>
        </div>

        <div style="text-align: right; margin-top: 1rem;">
          <button type="submit" class="btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>

  <script src="<?php echo e(asset('js/triage.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/triage.blade.php ENDPATH**/ ?>