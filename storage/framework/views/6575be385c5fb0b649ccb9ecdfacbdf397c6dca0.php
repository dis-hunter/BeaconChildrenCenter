<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor's Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="<?php echo e(asset('css/doctorDash.css')); ?>">
  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</head>
<body>
  <!-- Header -->
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
          <a href="<?php echo e(route('profile.show')); ?>">View Profile</a>
          <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>

          <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
          </form>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main>
    <!-- Sidebar -->
    <aside class="sidebar">
      <nav>
        <ul>
          <li class="active"><a href="<?php echo e(route('doctor.dashboard')); ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
          <li><a href="<?php echo e(route('profile.show')); ?>"><i class="fas fa-user"></i> My Profile</a></li>
          <li><a href="#"><i class="fas fa-book"></i> Booked Patients</a></li>
          <li><a href="#"><i class="fas fa-user-md"></i> Therapy</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Dashboard Section -->
    <?php if(!isset($profile)): ?>
    <section class="dashboard">
      <div class="welcome">
      <h3 id="greeting"></h3>
      </div>
      <div class="patient-queue">
        <h2>Patients Waiting</h2>
        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
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
       <button class="start-consult">Start Consultation</button>
        <button class="view-schedule">View Schedule</button>
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
const profileDetails = document.getElementById('profile-details'); // Get the profile details div

if (editProfileBtn && editProfileForm && profileDetails) {
  editProfileBtn.addEventListener('click', () => {
    // Hide the profile details
    profileDetails.style.display = 'none'; 

    // Show the edit profile form
    editProfileForm.style.display = 'block'; 

    editProfileBtn.style.display = 'none'; 
  });

  // Add an event listener for form submission
  editProfileForm.addEventListener('submit', () => {
    // Show the profile details
    profileDetails.style.display = 'block'; 

    // Hide the edit profile form
    editProfileForm.style.display = 'none'; 
  });
}
  </script>
</body>
</html>


<?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/doctorDash.blade.php ENDPATH**/ ?>