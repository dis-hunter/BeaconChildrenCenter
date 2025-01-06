<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Therapist Interface</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
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
            background-color:#111827;
            overflow-x: hidden;
            padding-top: 20px;
            transition: width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar img {
            width: 40px;
            height: 40px;
            margin: 0 auto 20px;
            display: block;
        }

        .sidebar a {
            padding: 12px 20px;
            text-decoration: none;
            font-size: 14px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
        }

        .sidebar a span:first-child {
            font-size: 20px;
            min-width: 20px;
            text-align: center;
        }

        .sidebar a span.menu-text {
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.3s, width 0.3s;
        }

        .sidebar.collapsed a span.menu-text {
            opacity: 0;
            width: 0;
            display: none;
        }

        .sidebar.collapsed a span:first-child {
            font-size: 20px;
            min-width: 40px;
        }

        .sidebar a:hover {
            background-color: #1f2937;
        }

        .main {
            margin-left: 200px;
            padding: 32px;
            background-color: #f3f4f6;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main.expanded {
            margin-left: 60px;
        }

        .sidebar-toggle {
            position: fixed;
            left: 200px;
            top: 20px;
            background: #111827;
            color: white;
            border: none;
            padding: 8px;
            cursor: pointer;
            border-radius: 0 4px 4px 0;
            transition: left 0.3s ease;
        }

        .sidebar-toggle.collapsed {
            left: 60px;
        }

        h2 {
            font-size: 24px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 24px;
        }

        h3 {
            font-size: 18px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 16px;
        }

        form {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 32px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        button[type="submit"] {
            background-color: #3b82f6;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        td button {
            background-color: #e2e8f0;
            color: #1f2937;
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        td button:hover {
            background-color: #cbd5e1;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <img src="{{ asset('images/logo.jpg') }}" alt="Logo">
    <a href="#"><span>👤</span> <span class="menu-text">Patient List</span></a>
    <a href="#" id="schedule-link"><span>📅</span> <span class="menu-text">Schedules</span></a>
    <a href="#"><span>📋</span> <span class="menu-text">Therapy Plans</span></a>
    <a href="#"><span>📊</span> <span class="menu-text">Reports</span></a>
    <a href="#"><span>🚪</span> <span class="menu-text">Logout</span></a>
</div>
<button class="sidebar-toggle">☰</button>

<div class="main">
    <h2 class="page-title">Therapist Page</h2>

    <h3>Document Therapy Needs</h3>
    <form id="therapyNeedsForm">
        <label for="patientName">Patient Name:</label>
        <input type="text" id="patientName" name="patientName" required>

        <label for="therapyNeeds">Therapy Needs:</label>
        <textarea id="therapyNeeds" name="therapyNeeds" rows="4" required></textarea>

        <label for="therapyGoals">Therapy Goals:</label>
        <textarea id="therapyGoals" name="therapyGoals" rows="4" required></textarea>

        <label for="numSessions">Number of Sessions:</label>
        <input type="number" id="numSessions" name="numSessions" required>

        <button type="submit">Save</button>
    </form>


    <div id="dynamic-content">
        <!-- Dynamic content will be loaded here -->
    </div>

    <h3>Patient Progress</h3>
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Session Details</th>
            <th>Progress Notes</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="progressTableBody">
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const main = document.querySelector('.main');
        const toggle = document.querySelector('.sidebar-toggle');

        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
            toggle.classList.toggle('collapsed');
        });

        const menuItems = document.querySelectorAll('.sidebar a');
        menuItems.forEach(item => {
            item.setAttribute('title', item.textContent.trim());
        });
    });

    scheduleLink.addEventListener('click', function (e) {
    e.preventDefault();
    
    // Show a loading message
    dynamicContent.innerHTML = '<p>Loading schedules...</p>';

    fetch('{{ route("calendar.content") }}')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load content');
            }
            return response.text();
        })
        .then(html => {
            dynamicContent.innerHTML = html; // Replace with the fetched content
        })
        .catch(error => {
            dynamicContent.innerHTML = '<p>Error loading schedules. Please try again.</p>';
            console.error('Error loading content:', error);
        });
});

</script>


<script src="{{asset('js/add_cal.js')}}"></script>

</body>
</html>
