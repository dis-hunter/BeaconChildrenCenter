<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor's Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel=stylesheet href="{{asset ('css/doctorDash.css')}}">
 
</head>
<body>

  <header>
    <div class="profile">
      <img src="Dr.Oringe.jpg" alt="Doctor Profile Picture">
      <div>
        <h2  style="margin-bottom: 6px;">Dr. {{ $firstName }} {{ $lastName }}</h2>
        <p style="margin-top:0">Pediatrician</p>
      </div>
    </div>
    <div class="notifications">
      <div class="dropdown">
        <button class="dropbtn"><i class="fas fa-user"></i></button>
        <div class="dropdown-content">
          <a href="#"  id="dropdown-profile-link">View Profile</a>
          <a href="#">Settings</a>
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
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
          <li><a href="#" id="therapist-link"><i class="fas fa-user-md"></i> Therapy </a></li> 
        </ul>
      </nav>
    </aside>

    <section class="dashboard" id="dashboard-content">
      <div class="welcome">
        <h3>Good morning, Dr. {{ $lastName }}!</h3>
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
        <!-- <button class="start-consult">Start Consultation</button> -->
        <!-- <button class="view-schedule">View Schedule</button> -->
      </div>
    </section>

    <section class="profile-content" id="profile-content" style="display: none;">
      <h2>Doctor's Profile</h2>
      <p>This is where you would display the doctor's profile information.</p>
    </section>

    <section class="content" id="booked-content" style="display: none;">
    @if(isset($appointmentsWithChildNames) && count($appointmentsWithChildNames) > 0)
    <table>
        <thead>
            <tr>
                <th>Child's Name</th>
                <th>Appointment Start Time</th>
                <th>Appointment End Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointmentsWithChildNames as $appointment)
                <tr>
                    <td>{{ $appointment['child_name'] }}</td>
                    <td>{{ $appointment['appointment_start_time'] }}</td>
                    <td>{{ $appointment['appointment_end_time'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No appointments for today.</p>
@endif

</section>




    <section class="content" id="therapist-content" style="display: none;">
      <h2>Therapy List</h2>
      <p>This is where you would display the therapy list.</p>
    </section>
  <!--
    <div class="calendar-section">
        <h3>Appointments Calendar</h3>

            <button class="btn btn-primary">View Calendar</button>
        </a>
    </div>
-->
  </main>

  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src="{{asset ('js/doctorDash.js')}}"></script>
</body>
</html>