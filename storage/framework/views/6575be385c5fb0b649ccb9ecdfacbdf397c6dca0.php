<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor's Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<<<<<<< HEAD
  <link rel="stylesheet" href="<?php echo e(asset('css/doctorDash.css')); ?>">
  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="profile">
      <i class="fas fa-user-md fa-4x"></i>
      <div>
        <h2 style="margin-bottom: 6px;">Dr. <?php echo e($firstName ?? ''); ?> <?php echo e($lastName ?? ''); ?></h2>
        <p style="margin-top:0">Pediatrician</p>
      </div>
    </div>
    <div class="notifications">
      <div class="datetime">
        <div id="date"></div>
        <div class="clock" id="clock"></div>
      </div>
      <div class="dropdown">
        <button class="dropbtn"><i class="fas fa-user"></i></button>
        <div class="dropdown-content">
          <a href="<?php echo e(route('profile.show')); ?>">View Profile</a>
          <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
=======
  <link rel=stylesheet href="<?php echo e(asset ('css/doctorDash.css')); ?>">

</head>
<body>

  <header>
  <div class="profile">
  <i class="fas fa-user-md fa-4x"></i> <div>
    <h2 style="margin-bottom: 6px;">Dr. <?php echo e($firstName ?? ''); ?> <?php echo e($lastName ?? ''); ?></h2>
    <p style="margin-top:0">Pediatrician</p>
  </div>
</div>
    <div class="notifications">
    <div class="clock" id="clock"></div> 
      <div class="dropdown">
        <button class="dropbtn"><i class="fas fa-user"></i></button>
        <div class="dropdown-content">
          <a href="#"  id="dropdown-profile-link">View Profile</a>
          <a href="#">Settings</a>
          <a href="<?php echo e(route('profile.show')); ?>">View Profile</a>
          <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>

>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
          <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
          </form>
        </div>
      </div>
    </div>
  </header>

<<<<<<< HEAD
  <!-- Main Content -->
  <main>
    <!-- Sidebar -->
    <aside class="sidebar">
      <nav>
        <ul>
=======
  <main>
    <aside class="sidebar">
      <nav>
        <ul>
          <li class="active"><a href="#" id="dashboard-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
          <li><a href="#" id="profile-link"><i class="fas fa-user"></i> Profile</a></li>
          <li><a href="#" id="booked-link"><i class="fas fa-book"></i> Booked Patients</a></li> 
          <li> <a id="therapist-link" href="#">Therapy</a></li>

          <li><a href="#" id="calendar-link"><i class="fas fa-user-md"></i> View Calendar</a></li> 
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
          <li class="active"><a href="<?php echo e(route('doctor.dashboard')); ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
          <li><a href="<?php echo e(route('profile.show')); ?>"><i class="fas fa-user"></i> My Profile</a></li>
          <li><a href="#"><i class="fas fa-book"></i> Booked Patients</a></li>
          <li><a href="#"><i class="fas fa-user-md"></i> Therapy</a></li>
        </ul>
      </nav>
    </aside>

<<<<<<< HEAD
    <!-- Dashboard Section -->
    <?php if(!isset($profile)): ?>
    <section class="dashboard">
      <div class="welcome">
        <h3 id="greeting"></h3>
=======
    <section class="dashboard" id="dashboard-content">
      <div class="welcome">
      <h3 id="greeting"></h3>
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
      </div>
      <div class="patient-queue">
        <h2>Patients Waiting</h2>
        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
<<<<<<< HEAD
          <thead>
            <tr>
              <!-- <th>Patient Name</th> -->
            </tr>
          </thead>
          <tbody id="post-triage-list">
            <tr>
              <td colspan="6" style="text-align: center;">Loading...</td>
            </tr>
          </tbody>
        </table>
        <ul id="patient-list"></ul>
      </div>
    </section>
    <?php endif; ?>

    <!-- Profile Section -->
    <?php if(isset($profile)): ?>
    <section class="profile-content">
      <h2>Doctor's Profile</h2>
      <div id="profile-details">
        <p><strong>Full Name:</strong> <?php echo e($profile['fullname']['first_name']); ?> <?php echo e($profile['fullname']['last_name']); ?></p>
        <p><strong>Telephone:</strong> <?php echo e($profile['telephone']); ?></p>
        <p><strong>Email:</strong> <?php echo e($profile['email']); ?></p>
      </div>
      <button id="edit-profile-btn">Edit Profile</button>

      <!-- Edit Profile Form -->
      <div id="edit-profile-form" style="display: none;">
        <form method="POST" action="<?php echo e(route('doctor.profile.update')); ?>">
          <?php echo csrf_field(); ?>
          <label for="first_name">First Name:</label>
          <input type="text" id="first_name" name="fullname[first_name]" value="<?php echo e($profile['fullname']['first_name']); ?>"><br><br>
          <label for="last_name">Last Name:</label>
          <input type="text" id="last_name" name="fullname[last_name]" value="<?php echo e($profile['fullname']['last_name']); ?>"><br><br>
          <label for="telephone">Telephone:</label>
          <input type="text" id="telephone" name="telephone" value="<?php echo e($profile['telephone']); ?>"><br><br>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="<?php echo e($profile['email']); ?>"><br><br>
          <button type="submit">Save Changes</button>
        </form>
      </div>
    </section>
    <?php endif; ?>
  </main>

  <!-- JavaScript -->
  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src="<?php echo e(asset ('js/doctorDash.js')); ?>"></script>
  <script>
    // Toggle Edit Profile Form
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const editProfileForm = document.getElementById('edit-profile-form');
    const profileDetails = document.getElementById('profile-details');

    if (editProfileBtn && editProfileForm && profileDetails) {
      editProfileBtn.addEventListener('click', () => {
        profileDetails.style.display = 'none';
        editProfileForm.style.display = 'block';
        editProfileBtn.style.display = 'none';
      });

      editProfileForm.addEventListener('submit', () => {
        profileDetails.style.display = 'block';
        editProfileForm.style.display = 'none';
      });
    }

    // Function to display live date and time
    function updateDateTime() {
      const now = new Date();
      const dateElement = document.getElementById('date');
      const clockElement = document.getElementById('clock');

      // Format the date
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      const dateString = now.toLocaleDateString('en-US', options);

      // Format the time
      const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

      // Update the DOM
      dateElement.textContent = dateString;
      clockElement.textContent = timeString;
    }

    // Update date and time every second
    setInterval(updateDateTime, 1000);
    updateDateTime(); // Initial call to display immediately
  </script>
=======
        <thead>
            <tr>
               
                <!-- <th>Patient Name</th> -->
                
            </tr>
        </thead>
        <tbody id="post-triage-list">
            <tr>
                <td colspan="6" style="text-align: center;">Loading...</td>
            </tr>
        </tbody>
    </table>
        <ul id="patient-list"></ul>
      </div>
      <div class="actions">
        <!-- <button class="start-consult">Start Consultation</button> -->
        <!-- <button class="view-schedule">View Schedule</button> -->
      </div>
    </section>

    <section class="profile-content" id="profile-content" style="display: none;">

    <br><br>
      <h2>Doctor's Profile</h2>
      <p>This is where you would display the doctor's profile information.</p>
    </section>

    <section class="content" id="booked-content" style="display: none;">
    <!-- This section will be populated with the doctor's booked appointments -->
</section>





    <section class="content" id="therapist-content" style="display: none;">
    <div id="therapist-content" style="display: none;">
    <div id="therapy-appointments-table"></div>
        
    </div>


    </section>
  
    
    <!-- Section for Calendar (Initially Hidden) -->
    <section class="content" id="calendar-content" style="display: none;">
    <?php echo $__env->make('calendar', ['doctorSpecializations' => $doctorSpecializations ?? []], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    
</section>


  </main>

  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src="<?php echo e(asset ('js/doctorDash.js')); ?>"></script>
  <script>
    function updateClock() {
      const now = new Date();
      const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
      document.getElementById('clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    function updateGreeting() {
      const now = new Date();
      const hours = now.getHours();
      let greeting = "Good morning"; // Default to morning
      if (hours >= 12 && hours < 18) {
        greeting = "Good afternoon";
      } else if (hours >= 18) {
        greeting = "Good evening";
      }
      document.getElementById('greeting').textContent = `${greeting}, Dr. <?php echo e($lastName); ?>!`;
    }
    updateGreeting(); 
    setInterval(updateGreeting, 60 * 60 * 1000);
  </script>



<script>
    // Fetch user's specialization and doctor details on page load
    window.onload = function() {
        fetch('<?php echo e(route('get.user.specialization.doctor')); ?>')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            // Prefill specialization select dropdown
            var specializationSelect = document.getElementById('doctor_specialization');
            var option = document.createElement('option');
            option.value = data.specialization_id;
            option.textContent = data.specialization;
            specializationSelect.appendChild(option);

            // Prefill doctor select dropdown
            var doctorSelect = document.getElementById('specialist');
            var doctorOption = document.createElement('option');
            doctorOption.value = data.doctor_id;
            doctorOption.textContent = data.doctor_name;
            doctorSelect.appendChild(doctorOption);

            // Disable both dropdowns after pre-filling
            specializationSelect.disabled = true;
            doctorSelect.disabled = true;
        })
        .catch(error => {
            console.error('Error fetching user specialization and doctor:', error);
        });
    }
</script>
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
</body>
</html><?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/doctorDash.blade.php ENDPATH**/ ?>