<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor's Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/doctorDash.css') }}">
  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="profile">
      <img src="Dr.Oringe.jpg" alt="Doctor Profile Picture">
      <div>
        <h2>Dr. Florence Oringe</h2>
        <p>Pediatrician</p>
      </div>
    </div>
    <div class="notifications">
      <div class="dropdown">
        <button class="dropbtn"><i class="fas fa-user"></i></button>
        <div class="dropdown-content">
          <a href="{{ route('doctor.profile') }}">View Profile</a>
          <a href="#">Settings</a>
          <a href="#">Log Out</a>
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
          <li class="active"><a href="{{ route('doctor.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
          <li><a href="{{ route('doctor.profile') }}"><i class="fas fa-user"></i> Profile</a></li>
          <li><a href="#"><i class="fas fa-book"></i> Booked Patients</a></li>
          <li><a href="#"><i class="fas fa-user-md"></i> Therapy</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Dashboard Section -->
    @if(!isset($profile))
    <section class="dashboard">
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
    @endif

    <!-- Profile Section -->
    @if(isset($profile))
    <section class="profile-content">
      <h2>Doctor's Profile</h2>
      <div id="profile-details">
        <p><strong>Full Name:</strong> {{ $profile['fullname']['first_name'] }} {{ $profile['fullname']['last_name'] }}</p>
        <p><strong>Telephone:</strong> {{ $profile['telephone'] }}</p>
        <p><strong>Email:</strong> {{ $profile['email'] }}</p>
      </div>
      <button id="edit-profile-btn">Edit Profile</button>

      <!-- Edit Profile Form -->
      <div id="edit-profile-form" style="display: none;">
        <form method="POST" action="{{ route('doctor.profile.update') }}">
          @csrf
          <label for="first_name">First Name:</label>
          <input type="text" id="first_name" name="fullname[first_name]" value="{{ $profile['fullname']['first_name'] }}"><br><br>
          <label for="last_name">Last Name:</label>
          <input type="text" id="last_name" name="fullname[last_name]" value="{{ $profile['fullname']['last_name'] }}"><br><br>
          <label for="telephone">Telephone:</label>
          <input type="text" id="telephone" name="telephone" value="{{ $profile['telephone'] }}"><br><br>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" value="{{ $profile['email'] }}"><br><br>
          <button type="submit">Save Changes</button>
        </form>
      </div>
    </section>
    @endif
  </main>

  <!-- JavaScript -->
  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src="{{asset ('js/doctorDash.js')}}"></script>
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
