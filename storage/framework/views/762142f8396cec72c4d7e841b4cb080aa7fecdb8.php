<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor's Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel=stylesheet href="<?php echo e(asset ('css/doctorDash.css')); ?>">
 
</head>
<body>

  <header>
    <div class="profile">
      <img src="Dr.Oringe.jpg" alt="Doctor Profile Picture">
      <div>
        <h2  style="margin-bottom: 6px;">Dr. Florence Oringe</h2>
        <p style="margin-top:0">Pediatrician</p>
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
        <h3>Good morning, Dr. Oringe!</h3>
      </div>
      <div class="patient-queue">
        <h2>Patients Waiting</h2>
        <ul id="patient-list"></ul>
      </div>
      <div class="actions">
        <button class="start-consult">Start Consultation</button>
        <button class="view-schedule">View Schedule</button>
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

  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src="<?php echo e(asset ('js/doctorDash.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\tobik\OneDrive\Documents\GitHub\BeaconChildrenCenter\resources\views/doctorDash.blade.php ENDPATH**/ ?>