<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

        :root {
            --primary-color: #2563eb;
            --primary-light: #dbeafe;
            --success-color: #059669;
            --success-light: #d1fae5;
            --warning-color: #d97706;
            --warning-light: #fef3c7;
            --text-primary: #1f2937;
            --text-secondary: #4b5563;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 32px;
            background-color: #f9fafb;
            color: var(--text-primary);
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        .search-container {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .search-bar {
            flex-grow: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 12px center;
            background-size: 20px;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .table-wrapper {
            max-height: 600px;
            overflow: auto;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-top: 16px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            position: sticky;
            top: 0;
            background-color: #f8fafc;
            padding: 12px 16px;
            font-weight: 500;
            color: var(--text-secondary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 16px;
            color: var(--text-primary);
            font-size: 0.875rem;
            border-bottom: 1px solid var(--border-color);
        }

        tr:hover {
            background-color: #f8fafc;
        }

        .specialization {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .cardiology {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        .neurology {
            background-color: var(--success-light);
            color: var(--success-color);
        }

        .calendar-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--primary-color);
        }

        .calendar-icon:hover {
            background-color: var(--primary-light);
        }

        .no-results {
            text-align: center;
            padding: 48px 0;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        /* Scrollbar styling */
        .table-wrapper::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            .container {
                padding: 16px;
            }

            .table-wrapper {
                max-height: 400px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Doctors List</h1>
        
        <div class="search-container">
            <div class="search-bar">
                <input type="text" 
                       class="search-input" 
                       placeholder="Search doctors by name, ID, or specialization..."
                       onkeyup="searchDoctors(this.value)">
            </div>
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
                        <th>Calendar</th>
                    </tr>
                </thead>
                <tbody id="doctorsTable">
                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="doctor-row">
                        <td><?php echo e($doctor->id); ?></td>
                        <td><?php echo e($doctor->staff->fullname); ?></td>
                        <td><?php echo e($doctor->staff->telephone); ?></td>
                        <td><?php echo e($doctor->staff->email); ?></td>
                        <td><?php echo e($doctor->staff->gender_id); ?></td>
                        <td><?php echo e($doctor->staff->role_id); ?></td>
                        <td>
                            <span class="specialization <?php echo e(strtolower($doctor->specialization)); ?>"><?php echo e($doctor->specialization); ?></span>
                        </td>
                        <td><?php echo e($doctor->staff_id); ?></td>
                        <td>
                            <span class="calendar-icon">📅</span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="no-results" id="noResults" style="display: none;">
            No doctors found.
        </div>
    </div>

    <script>
        function searchDoctors(query) {
            query = query.toLowerCase();
            const rows = document.querySelectorAll('.doctor-row');
            let found = false;

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
</html><?php /**PATH C:\Users\sharo\Desktop\Today\htdocs\BeaconChildrenCenter-4\resources\views/display_doctors.blade.php ENDPATH**/ ?>