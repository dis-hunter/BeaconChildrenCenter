<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Doctors List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        /* Sidebar Styles */
        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #111827;
            overflow: visible;
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

        .sidebar img {
            width: 40px;
            height: 40px;
            margin: 0 auto 20px;
            display: block;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 200px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 60px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .search-bar {
            flex-grow: 1;
            margin-right: 16px;
        }

        .search-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .table-wrapper {
            max-height: 600px;
            overflow-x: auto;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            white-space: nowrap;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        th {
            color: #666;
            font-weight: 500;
            background-color: #f9f9f9;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .specialization {
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 14px;
            display: inline-block;
        }

        .cardiology {
            background-color: #e8f0fe;
            color: #1a73e8;
        }

        .neurology {
            background-color: #ffe8ec;
            color: #e91e63;
        }

        .no-results {
            text-align: center;
            color: #777;
            font-style: italic;
            margin-top: 16px;
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

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
        <a href="#"><span class="icon">➕</span> <span class="text">Add Patient</span></a>
        <a href="#"><span class="icon">👥</span> <span class="text">Parents</span></a>
        <a href="#"><span class="icon">📅</span> <span class="text">Appointments</span></a>
        <a href="#"><span class="icon">🕒</span> <span class="text">Visit</span></a>
        <a href="{{route('doctors')}}"><span class="icon">👨‍⚕️</span> <span class="text">Doctors</span></a>
        <a href="#"><span class="icon">💰</span> <span class="text">Payments</span></a>
        <a href="#"><span class="icon">👥</span> <span class="text">Staff</span></a>
    </div>

    <div class="toggle-button" id="toggle-button" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="container">
            <h1>Doctors List</h1>
            
            <div class="search-container">
                <div class="search-bar">
                    <input type="text" 
                           class="search-input" 
                           placeholder="Search doctors by name, ID, or specialization..."
                           onkeyup="searchDoctors(this.value)">
                </div>
                <form action="{{ route('doctor.form')}}" method="GET">
                <button type="submit" class="add-button">
                <span>+</span>
                Add Doctor
            </button>
            </form>

            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Role</th>
                            <th>Specialisation</th>
                            <th>Staff ID</th>
                        </tr>
                    </thead>
                    <tbody id="doctorsTable">
    @foreach ($doctors as $doctor)
    <tr class="doctor-row">
        <td>{{ $doctor->id }}</td>
        <td>{{ $doctor->staff->fullname['first_name'] }} {{ $doctor->staff->fullname['last_name'] }}</td>
        <td>{{ $doctor->staff->telephone }}</td>
        <td>{{ $doctor->staff->email }}</td>
        <td>{{ $doctor->staff->gender_id }}</td>
        <td>{{ $doctor->staff->role_id }}</td>
        <td>
        {{ $doctor->specialization }}
        </td>
        <td>{{ $doctor->staff_id }}</td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>

            <div class="no-results" id="noResults" style="display: none;">
                No doctors found.
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleButton = document.getElementById('toggle-button');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            toggleButton.classList.toggle('collapsed');
        }

        function searchDoctors(query) {
            query = query.toLowerCase();
            const rows = document.querySelectorAll('.doctor-row');
            let found = false;
//iterate over rows and check if query is in the row
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                    found = true;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('noResults').style.display = found ? 'none' : 'block';
        }
    </script>
</body>
</html>