<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/lux/bootstrap.min.css" />
<link rel="stylesheet" href="{{asset('css/navbar-fixed-left.min.css')}}">

<script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous"></script>

<script async defer src="https://buttons.github.io/buttons.js"></script>
@livewireStyles

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-left" id="mainNav">

    <a class="navbar-brand ml-4" href>Reception</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
        aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse ml-3" id="navbarsExampleDefault">
        <ul class="navbar-nav">

            @auth
            <li class="nav-item">
                <a href="/dashboard" class="nav-link"><span class="icon">〰️</span> <span class="text">Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a href="/patients" class="nav-link"><span class="icon">🚑</span> <span class="text">Existing Patient</span></a>
            </li>
            <li class="nav-item">
                <a href="/guardians" class="nav-link"><span class="icon">➕</span> <span class="text">New Patient</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reception.calendar') }}" class="nav-link">
                    <span class="icon">📅</span>
                    <span class="text">Appointments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('leave2.request') }}" class="nav-link">
                    <span class="icon">🏖️</span>
                    <span class="text">leave request</span>
                </a>
            </li>



            <li class="nav-item">
                <a href="/visithandle" class="nav-link"><span class="icon">🕒</span> <span class="text">Visit</span></a>
            </li>

            <li class="nav-item">
                <a href="/get-invoices" class="nav-link"><span class="icon">📑</span><span class="text">Invoices</span></a>
            </li>



            {{-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item">Action</a>
                    <a class="dropdown-item">Another action</a>
                    <a class="dropdown-item">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item">Separated link</a>
                    <a class="dropdown-item">One more separated link</a>
                </div>
            </li> --}}
        </ul>
        {{-- <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-class="fixed-left">
                    <i class="fa fa-arrow-left"></i>
                    Fixed Left
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-class="fixed-top">
                    <i class="fa fa-arrow-up"></i>
                    Fixed Top
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-class="fixed-right">
                    <i class="fa fa-arrow-right"></i>
                    Fixed Right
                </a>
            </li>

        </ul> --}}
        @endauth
    </div>

    <!-- User Dropdown Menu at Top-Right -->

</nav>
<nav class="navbar navbar-expand-md responsive-navbar" id="Account">
    <div class="global-search"><x-global-search/></div>

    <div class="ml-auto">
        <ul class="navbar-nav">
            <li class="nav-item">
                <div class="d-flex align-items-center">
                    <!-- Bell Icon -->
                    <i class="fa fa-bell position-relative" style="font-size: 1.25rem; color: #555;"></i>
                </div>
            </li>
            <li class="nav-item" x-data="{ showMessage: true }" x-show="showMessage" style="transition: opacity 0.5s ease;">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show p-2 m-0 ms-2" role="alert" x-init="setTimeout(() => showMessage = false, 5000)">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show p-2 m-0 ms-2" role="alert" x-init="setTimeout(() => showMessage = false, 5000)">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
                @endif
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user"></i>
                    @auth
                    {{auth()->user()->fullname->first_name ?? ''.' '.auth()->user()->fullname->last_name ?? ''}}
                    @else
                    Account
                    @endauth
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    @auth

                    <form action="/logout" method="post">@csrf<button class="dropdown-item" type="submit">Logout</button></form>
                    <a class="dropdown-item" href="{{route('profile.show')}}">Profile</a>

                    @else
                    <a class="dropdown-item" href="{{route('login')}}">Login</a>
                    <a class="dropdown-item" href="{{route('register')}}">Register</a>

                    @endauth
                </div>
            </li>
        </ul>

        <div id="calendar-section" class="col-md-9 p-4" style="display: none;">
            <!-- Calendar will be displayed here dynamically -->
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarSection = document.getElementById('calendar-section');
        const sidebarLinks = document.querySelectorAll('.load-section');

        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const section = this.getAttribute('data-section');

                if (section === 'calendar-section') {
                    // Fetch calendar content (if not already loaded)
                    if (!calendarSection.innerHTML.trim()) {
                        fetch('/calendar')
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Failed to load calendar');
                                }
                                return response.text();
                            })
                            .then(html => {
                                calendarSection.innerHTML = html;
                                calendarSection.style.display = 'block';
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                calendarSection.innerHTML = '<p class="text-danger">Failed to load calendar.</p>';
                                calendarSection.style.display = 'block';
                            });
                    } else {
                        calendarSection.style.display = 'block';
                    }
                } else {
                    // Hide the calendar section for other links
                    calendarSection.style.display = 'none';
                }
            });
        });
    });
</script>
