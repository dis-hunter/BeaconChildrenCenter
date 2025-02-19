<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor's Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel=stylesheet href="{{asset ('css/doctorDash.css')}}">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body>

@section('header_sidebar')  
<header>
    <div class="profile">
      <i class="fas fa-user-md fa-4x"></i>
      <div>
        <h2 style="margin-bottom: 6px;">Dr. {{ $firstName ?? '' }} {{ $lastName ?? '' }}</h2>
        
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
          <a href="#"  id="dropdown-profile-link">View Profile</a>
          <a href="#">Settings</a>
          <a href="{{ route('profile.show') }}">View Profile</a>
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </header>

  <main>
  @yield('content')
    <aside class="sidebar">
    <nav>
        <ul>
          <li class="active"><a href="#" id="dashboard-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
          <li><a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> My Profile</a></li>
          <li><a href="#" id="booked-link"><i class="fas fa-book"></i> Booked Patients</a></li> 
          <li> <a id="therapist-link" href="#"><i class="fas fa-user-md"></i>Therapy Patient List</a></li>

          <li><a href="#" id="calendar-link"><i class="fas fa-user-md"></i> View Schedule</a></li> 
         
        
          
        
        </ul>
      </nav>
    </aside>
    @show 

    <section class="dashboard" id="dashboard-content">
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
    @include('calendar', ['doctorSpecializations' => $doctorSpecializations ?? []])


    
</section>


  </main>

  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src="{{asset ('js/doctorDash.js')}}"></script>
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
      document.getElementById('greeting').textContent = `${greeting}, Dr. {{ $lastName }}!`;
    }
    updateGreeting(); 
    setInterval(updateGreeting, 60 * 60 * 1000);
  </script>



<script>
    // Fetch user's specialization and doctor details on page load
    window.onload = function() {
        fetch('{{ route('get.user.specialization.doctor') }}')
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
    
    import { prevMonth, nextMonth } from '/public/js/calendar.js'; // Adjust the path if necessary

// Ensure these buttons have the correct IDs or class names
document.getElementById('prev-month-button').addEventListener('click', prevMonth);
document.getElementById('next-month-button').addEventListener('click', nextMonth);

</script>
</body>
</html>