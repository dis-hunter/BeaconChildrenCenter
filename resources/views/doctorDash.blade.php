<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel=stylesheet href="{{asset ('css/doctorDash.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/js/app.js','resources/css/app.css'])
    <style>
        .dot-loader {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            height: 40px;
        }

        .dot {
            width: 12px;
            height: 12px;
            background-color: #007bff;
            border-radius: 50%;
            animation: bounce 1.2s infinite ease-in-out;
        }

        .dot:nth-child(1) {
            animation-delay: 0s;
        }

        .dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .dot:nth-child(3) {
            animation-delay: 0.4s;
        }
        .cancel-btn,
.reschedule-btn {
    display: none !important;
}

        @keyframes bounce {
            0%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(12px);
            }
        }
    </style>

</head>
<body>

@section('header_sidebar')
    <header>
        <div class="profile">
            <i class="fas fa-user-md fa-4x"></i>
            <div>
                <h2 style="margin-bottom: 6px;">Dr. {{ $firstName ?? '' }} {{ $lastName ?? '' }}</h2>
                <p style="font-size: 18px; color:white;">{{ $specialization ?? '' }}</p>

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
                    <a href="{{ route('profile.show') }}">View Profile</a>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
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
                    <li class="active"><a href="#" id="dashboard-link"><i class="fas fa-tachometer-alt"></i>
                            Dashboard</a></li>
                    <li><a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> My Profile</a></li>
                    <li><a href="#" id="booked-link"><i class="fas fa-book"></i> Booked Patients</a></li>
                    <li><a id="therapist-link" href="#"><i class="fas fa-user-md"></i>Therapy Patient List</a></li>

                    <li><a href="#" id="calendar-link"><i class="fas fa-user-md"></i> View Schedule</a></li>


                </ul>
            </nav>
        </aside>
        @show

        <section class="dashboard" id="dashboard-content">
            <div class="flex justify-between w-full items-center">
                <div class="welcome">
                    <h3 id="greeting"></h3>
                </div>
                <div>
                    <x-global-search/>
                </div>
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
                        <td colspan="6" style="text-align: center;">
                            <div class="dot-loader">
                                <span class="dot"></span>
                                <span class="dot"></span>
                                <span class="dot"></span>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <ul id="patient-list"></ul>
            </div>
        </section>


        <section class="content" id="booked-content" style="display: none;">
            <!-- This section will be populated with the doctor's booked appointments -->
        </section>

        <section class="content" id="therapist-content" style="display: none;">

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
            const timeString = now.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit', second: '2-digit'});
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
            document.getElementById('greeting').textContent = `${greeting}, Dr. {{ $lastName }}`;
        }

        updateGreeting();
        setInterval(updateGreeting, 60 * 60 * 1000);
    </script>



    <script>
        // Fetch user's specialization and doctor details on page load
        window.onload = function () {
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

        import {prevMonth, nextMonth} from '/public/js/calendar.js'; // Adjust the path if necessary

        // Ensure these buttons have the correct IDs or class names
        document.getElementById('prev-month-button').addEventListener('click', prevMonth);
        document.getElementById('next-month-button').addEventListener('click', nextMonth);

    </script>
</body>
</html>
