<!DOCTYPE html>
<html>
<head>
    <title>Therapist Interface</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
            background-color: #111827;
            overflow-x: hidden;
            padding-top: 20px;
            color: white;
        }

        .sidebar a {
            padding: 12px 20px;
            text-decoration: none;
            font-size: 14px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #1f2937;
        }

        .sidebar img {
            width: 40px;
            height: 40px;
            margin: 0 auto 20px;
        }

        .main {
            margin-left: 200px;
            padding: 40px;
            background-color: #f3f4f6;
            min-height: 100vh;
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

        .calendar-icon {
            color: #64748b;
            cursor: pointer;
        }

        .page-title {
            font-size: 24px;
            color: #111827;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo">
    <a href="#"><span>➕</span> Add Patient</a>
    <a href="#"><span>👥</span> Parents</a>
    <a href="#"><span>📅</span> Appointments</a>
    <a href="#"><span>🕒</span> Visit</a>
    <a href="<?php echo e(route('doctors')); ?>"><span>👨‍⚕️</span> Doctors</a>
    <a href="#"><span>💰</span> Payments</a>
    <a href="#"><span>👥</span> Staff</a>
</div>

<div class="main">
    <h1 class="page-title">Doctor's Details</h1>
    
    <div class="search-bar">
        <input type="text" placeholder="Search Doctor Name" class="search-input">
        <form action="<?php echo e(route('doctor.form')); ?>" method="GET">
            <button type="submit" class="add-button">
                <span>+</span>
                Add Doctor
            </button>
        </form>
    </div>

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
    // Your existing JavaScript remains unchanged
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

    loadProgress();
</script>

</body>
</html><?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/Receiptionist\Receiptionist_dashboard.blade.php ENDPATH**/ ?>