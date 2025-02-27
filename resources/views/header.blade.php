<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/lux/bootstrap.min.css" />
<script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous"></script>

  <script async defer src="https://buttons.github.io/buttons.js"></script>
<style>
    .navbar-nav {
    display: flex;
    justify-content: center;
    align-items: center;
}

.d-flex.mx-auto {
    flex-grow: 1;
    text-align: center;
}

.nav-item .nav-link {
    padding: 10px 15px;
    color:white;
}

.navbar-toggler {
    border: none;
    outline: none;
}
</style>
<nav class="navbar navbar-expand-md responsive-navbar" id="Account">
    <div class="shrink-0 flex items-center ml-5">
        <a href="{{ route('home') }}">
            <x-application-mark class="block h-9 w-auto" />
        </a>
    </div>

    <button
        class="navbar-toggler mr-4"
        type="button"
        data-toggle="collapse"
        data-target="#navbarContent"
        aria-controls="navbarContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
    <div class="d-flex mx-auto justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('home')}}"> Home </a>
            </li>
            <li class="nav-item">
                <a style="color:white;" class="nav-link"> About Us </a>
            </li>
            <li class="nav-item">
                <a style="color:white;"  class="nav-link"> Contact Us </a>
            </li>
    </ul>
</div>
    <div class="ml-auto">
        <ul class="navbar-nav">
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

                @endauth
            </div>
        </li>
    </ul>
</div>
    </div>
    </nav>
