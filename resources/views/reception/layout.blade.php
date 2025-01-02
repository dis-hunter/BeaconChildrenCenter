<!DOCTYPE html>
<html>
<head>
    <title>@yield('title','Reception')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    @livewireStyles
    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, sans-serif;
            background-color: #fff;
        }

        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #111827;
            overflow: visible;  /* Changed to visible to show hover content */
            padding-top: 20px;
            color: white;
            transition: width 0.3s ease;
            z-index: 100;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .toggle-button {
            position: fixed;
            left: 200px;
            top: 20px;
            background-color: #111827;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 0 6px 6px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: left 0.3s ease;
            z-index: 1000;
        }

        .toggle-button.collapsed {
            left: 60px;
        }

        .toggle-button::before {
            content: "◀";
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        .toggle-button.collapsed::before {
            transform: rotate(180deg);
        }

        .sidebar a {
            padding: 12px 20px;
            text-decoration: none;
            font-size: 14px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }

        .sidebar.collapsed a {
            padding: 12px;
            justify-content: center;
            width: 60px;
        }

        .sidebar.collapsed a:hover {
            width: auto;
            background-color: #1f2937;
            padding-right: 20px;
        }

        .sidebar.collapsed a span.icon {
            margin-right: 0;
            transition: margin 0.3s ease;
        }

        .sidebar.collapsed a:hover span.icon {
            margin-right: 12px;
        }

        .sidebar.collapsed a span.text {
            display: none;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar.collapsed a:hover span.text {
            display: inline;
            opacity: 1;
        }

        .sidebar a:hover {
            background-color: #1f2937;
        }

        .sidebar img {
            width: 40px;
            height: 40px;
            margin: 0 auto 20px;
            display: block;
        }

        .main {
            margin-left: 200px;
            padding: 40px;
            background-color: #f3f4f6;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main.expanded {
            margin-left: 60px;
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .search-input {
            padding: 8px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            width: 300px;
            background-color: #fff;
        }

        .add-button {
            background-color: #e2e8f0;
            color: #1f2937;
            padding: 8px 16px;
            border-radius: 20px;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-button:hover {
            background-color: #cbd5e1;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        th {
            background-color: #f8fafc;
            padding: 16px;
            text-align: left;
            font-weight: 500;
            color: #64748b;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
        }

        .specialty-badge {
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            display: inline-block;
        }

        .specialty-cardiology {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .specialty-neurology {
            background-color: #fce7f3;
            color: #9d174d;
        }

        .page-title {
            font-size: 24px;
            color: #111827;
            margin-bottom: 24px;
        }
        /* General Styling */
.search-section {
    margin: 20px 0;
}

.search-label span {
    font-size: 18px;
    font-weight: bold;
}

.search-input {
    border: 2px solid #007bff;
    border-radius: 8px;
    padding: 10px;
}

.search-input:focus {
    border-color: #0056b3;
    outline: none;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
}

.error-message {
    font-size: 14px;
    margin-top: 5px;
}

/* Loading Message */
.loading-message {
    font-size: 16px;
    font-style: italic;
}

/* Search Results Card */
.search-results {
    background-color: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.results-header {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    border-bottom: 2px solid #ddd;
    margin-bottom: 15px;
    padding-bottom: 5px;
}

.results-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.result-item {
    margin-bottom: 15px;
}

.result-item:last-child {
    margin-bottom: 0;
}
.table-result{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    background-color: #fff;
    transition: background-color 0.3s, box-shadow 0.3s;
    text-decoration: none;
    color: inherit;
}
.result-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    background-color: #fff;
    transition: background-color 0.3s, box-shadow 0.3s;
    text-decoration: none;
    color: inherit;
}

.result-link:hover {
    background-color: #f1f1f1;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.result-title {
    font-size: 16px;
    font-weight: bold;
    color: #007bff;
}

.result-details {
    font-size: 14px;
    color: #555;
}

/* No Results Message */
.no-results {
    font-size: 16px;
    color: #666;
    text-align: center;
    margin-top: 10px;
}
/* General Styling */
.loading-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 100px; /* Prevents layout shifting */
    height: 40px; /* Ensures consistent height */
    position: relative;
}

.loading-message {
    font-size: 16px;
    font-style: italic;
    visibility: visible; /* Shown only when wire:loading is active */
}

.loading-placeholder {
    visibility: hidden; /* Keeps the layout stable when loading is inactive */
    font-size: 16px;
    font-style: italic;
}


    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
    <a href="/patients"><span class="icon">➕</span> <span class="text">Patients</span></a>
    <a href="/patients/search"><span class="icon">🔍</span> <span class="text">Search</span></a>
    {{-- <a href="#"><span class="icon">👥</span> <span class="text">Parents</span></a> --}}
    <a href="#"><span class="icon">📅</span> <span class="text">Appointments</span></a>
    <a href="#"><span class="icon">🕒</span> <span class="text">Visit</span></a>
    {{-- <a href="#"><span class="icon">👨‍⚕️</span> <span class="text">Doctors</span></a>
    <a href="#"><span class="icon">💰</span> <span class="text">Payments</span></a>
    <a href="#"><span class="icon">👥</span> <span class="text">Staff</span></a> --}}
</div>

<div class="toggle-button" id="toggle-button" onclick="toggleSidebar()"></div>

<div class="main" id="main">
    @yield('content')
</div>

<script>
    //Sidebar toggle
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('.main');
        const toggleButton = document.getElementById('toggle-button');
        
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
        toggleButton.classList.toggle('collapsed');
    }
    </script>

@livewireScripts
</body>
</html>