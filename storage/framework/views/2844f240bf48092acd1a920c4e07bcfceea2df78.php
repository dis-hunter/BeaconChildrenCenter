<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Triage Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel=stylesheet href="<?php echo e(asset ('css/doctorDash.css')); ?>">
  <script src="<?php echo e(asset ('js/triageDash.js')); ?>"></script>
  
</head>

<style>.table-responsive {
    overflow-x: auto;
    margin: 20px 0;
}

.untriaged-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.untriaged-table th,
.untriaged-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.untriaged-table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #2d3748;
}

.untriaged-table tbody tr:hover {
    background-color: #f7fafc;
}

.untriaged-table .triage-btn {
    padding: 6px 12px;
    background-color: #4299e1;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.untriaged-table .triage-btn:hover {
    background-color: #3182ce;
}

.status-pending {
    color: #ed8936;
    font-weight: 500;
}

.status-complete {
    color: #48bb78;
    font-weight: 500;
}</style>

<body>
  <header>
    <div class="profile">
      <div>
      <h3 id="nurse-name" style="text-align: center; margin-bottom: 20px;"></h3>
        <p style="margin-top:0">Nurse</p>
      </div>
    </div>
    <div class="notifications">
      <div class="dropdown">
        <button class="dropbtn"><i class="fas fa-user"></i></button>
        <div class="dropdown-content">
          <a href="#"  id="dropdown-profile-link">View Profile</a>
          <a href="#">Settings</a>
          <a href="#">Log Out</a>
        </div>
      </div>
    </div>
  </header>

  <main>
    <aside class="sidebar">
      <nav>
        <ul>
          <li class="active"><a href="#" id="dashboard-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
          <li><a href="#" id="profile-link"><i class="fas fa-user"></i> Profile</a></li>
          <li><a href="#" id="booked-link"><i class="fas fa-book"></i> Booked Patients</a></li> 
          <li><a href="#" id="therapist-link"><i class="fas fa-user-md"></i> Therapy List</a></li> 
        </ul>
      </nav>
    </aside>

    
    <section class="dashboard" id="dashboard-content">
      <div class="welcome">
        <h3>Good morning!</h3>
      </div>
      <div class="patient-queue">
        <h2>Patients Waiting</h2>
        <div class="table-responsive">
          <table class="untriaged-table">
            <thead>
              <tr>
                <!-- <th>Visit ID</th> -->
                <th>Patient Name</th>
                <!-- <th>Child ID</th> -->
                <!-- <th>Staff ID</th> -->
                <!-- <th>Triage Status</th> -->
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="patient-list">
              <!-- Table rows will be populated by JavaScript -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="actions">
        <button class="start-consult">Triage</button>
      </div>
    </section>

    <section class="profile-content" id="profile-content" style="display: none;">
      <h2>Doctor's Profile</h2>
      <p>This is where you would display the doctor's profile information.</p>
    </section>

    <section class="content" id="booked-content" style="display: none;">
      <h2>Booked Patients</h2>
      <p>This is where you would display the booked patients list.</p>
    </section>

    <section class="content" id="therapist-content" style="display: none;">
      <h2>Therapy List</h2>
      <p>This is where you would display the therapy list.</p>
    </section>
  </main>

  <!-- <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script> -->
  
    
  </script>
</body>
</html><?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/triageDash.blade.php ENDPATH**/ ?>