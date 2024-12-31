<!DOCTYPE html>
<!--Happy New Year lol-->
<!--Route ni http://127.0.0.1:8000/receiptionist_dashboard /-->
<!--Most important comments ziko line:253,261-->
<html>
<head>
    <title>Receiptionist Dashboard</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        /*Styling one two one  two na pia nilitumia tailwind kustyle */
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

        /* Styles for collapsed sidebar */
        .sidebar.collapsed {
            width: 60px;
        }

        /* Toggle button styles */
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

        /* Styles for collapsed toggle button */
        .toggle-button.collapsed {
            left: 60px;
        }

        /* Arrow icon for toggle button */
        .toggle-button::before {
            content: "◀";
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        /* Rotate arrow icon when collapsed */
        .toggle-button.collapsed::before {
            transform: rotate(180deg);
        }

        /* Sidebar link styles */
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

        /* Styles for collapsed sidebar links */
        .sidebar.collapsed a {
            padding: 12px;
            justify-content: center;
            width: 60px;
        }

        /* Hover effect for collapsed sidebar links */
        .sidebar.collapsed a:hover {
            width: auto;
            background-color: #1f2937;
            padding-right: 20px;
        }

        /* Icon styles for collapsed sidebar links */
        .sidebar.collapsed a span.icon {
            margin-right: 0;
            transition: margin 0.3s ease;
        }

        /* Hover effect for icons in collapsed sidebar links */
        .sidebar.collapsed a:hover span.icon {
            margin-right: 12px;
        }

        /* Text styles for collapsed sidebar links */
        .sidebar.collapsed a span.text {
            display: none;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        /* Hover effect for text in collapsed sidebar links */
        .sidebar.collapsed a:hover span.text {
            display: inline;
            opacity: 1;
        }

        /* Hover effect for sidebar links */
        .sidebar a:hover {
            background-color: #1f2937;
        }

        /* Logo styles */
        .sidebar img {
            width: 40px;
            height: 40px;
            margin: 0 auto 20px;
            display: block;
        }

        /* Main content styles */
        .main {
            margin-left: 200px;
            padding: 40px;
            background-color: #f3f4f6;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Styles for expanded main content */
        .main.expanded {
            margin-left: 60px;
        }

        /* Search bar styles */
        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        /* Search input styles */
        .search-input {
            padding: 8px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            width: 300px;
            background-color: #fff;
        }

        /* Add button styles */
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

        /* Hover effect for add button */
        .add-button:hover {
            background-color: #cbd5e1;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Table header styles */
        th {
            background-color: #f8fafc;
            padding: 16px;
            text-align: left;
            font-weight: 500;
            color: #64748b;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Table cell styles */
        td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
        }

        /* Specialty badge styles */
        .specialty-badge {
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            display: inline-block;
        }

        /* Cardiology specialty badge styles */
        .specialty-cardiology {
            background-color: #dbeafe;
            color: #1e40af;
        }

        /* Neurology specialty badge styles */
        .specialty-neurology {
            background-color: #fce7f3;
            color: #9d174d;
        }

        /* Page title styles */
        .page-title {
            font-size: 24px;
            color: #111827;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>

<!-- Sidebar with navigation links -->
<div class="sidebar" id="sidebar">
    <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo">
    <a href="#"><span class="icon">➕</span> <span class="text">Add Patient</span></a>
    <a href="#"><span class="icon">👥</span> <span class="text">Parents</span></a>
    <a href="#"><span class="icon">📅</span> <span class="text">Appointments</span></a>
    <a href="#"><span class="icon">🕒</span> <span class="text">Visit</span></a>
<<<<<<< HEAD:resources/views/Receiptionist/Receiptionist_dashboard.blade.php
    <a href="{{route('doctors')}}"><span class="icon">👨‍⚕️</span> <span class="text">Doctors</span></a>       <!--so apo ndo link ya kwenda iyo page ya kuadd,search an kuview doctors-->
=======
    <a href="<?php echo e(route('doctors')); ?>"><span class="icon">👨‍⚕️</span> <span class="text">Doctors</span></a>
>>>>>>> 0d4ddc3b4b8880288309fd403947349652218e96:storage/framework/views/81f652faed8047f9e855380c4a9cd73cc11a4aed.php
    <a href="#"><span class="icon">💰</span> <span class="text">Payments</span></a>
    <a href="#"><span class="icon">👥</span> <span class="text">Staff</span></a>
</div>

<!-- Toggle button for collapsing/expanding the sidebar -->
<div class="toggle-button" id="toggle-button" onclick="toggleSidebar()"></div>

<!-- Main content area,so sana unaona ukiload inatokea kwa iyo page ya John Doe iyo tu ni static si the actual doctors so unaeza remove the main area ueke kenye relevant,i was thinking ikuwe welcome poge then ukiclick on links ndo saa inakupeleka kea izo place but you'll decide-->
<div class="main" id="main">
    <h1 class="page-title">Doctor's Details</h1>
    
    <!-- Search bar and add doctor button -->
    <div class="search-bar">
        <input type="text" placeholder="Search Doctor Name" class="search-input">
        <form action="<?php echo e(route('doctor.form')); ?>" method="GET">
            <button type="submit" class="add-button">
                <span>+</span>
                Add Doctor
            </button>
        </form>
    </div>

    <!-- Table displaying doctor details -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialisation</th>
                <th>Staff ID</th>
                <th>Calendar</th>
            </tr>
        </thead>
        <tbody id="progressTableBody">
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td><span class="specialty-badge specialty-cardiology">Cardiology</span></td>
                <td>1</td>
                <td>📅</td>
            </tr>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td><span class="specialty-badge specialty-neurology">Neurology</span></td>
                <td>1</td>
                <td>📅</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    // Function to toggle the sidebar
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('.main');
        const toggleButton = document.getElementById('toggle-button');
        
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
        toggleButton.classList.toggle('collapsed');
    }

    // Event listener for form submission (if present)
    document.getElementById('therapyNeedsForm')?.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('/therapist/save', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => alert(data.message))
            .catch(error => console.error('Error:', error));
    });

    // Function to load progress data
    function loadProgress() {
        fetch('/therapist/progress')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('progressTableBody');
                tbody.innerHTML = '';
                data.forEach(progress => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${progress.date}</td>
                        <td>${progress.sessionDetails}</td>
                        <td>${progress.progressNotes}</td>
                        <td><button>Edit</button></td>
                    `;
                    tbody.appendChild(row);
                });
            });
    }

    // Load progress data on page load
    loadProgress();
</script>

</body>
</html><?php /**PATH D:\github\BeaconChildrenCenter\resources\views/Receiptionist\Receiptionist_dashboard.blade.php ENDPATH**/ ?>