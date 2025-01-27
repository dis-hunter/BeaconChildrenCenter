<!DOCTYPE html>
<html>
<head>
    <title><?php echo $__env->yieldContent('title','Reception'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, sans-serif;
            background-color: #fff;
        }

        .main {
            margin-left: 200px;
            padding: 20px;
            background-color: #f3f4f6;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .global-search{
            margin-left: 250px;
        }

        .main.expanded {
            margin-left: 60px;
        }
        .dropdown-menu {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #e3e3e3;
        }

        @media (max-width: 768px) {
                    .main{
                        margin-left: 0;
                        width: 100%;
                    }
                    .global-search{
                        margin-left: 20px;
                    }
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
        /* --- Visit Page Styles --- */

        /* General Styling */
        .visit-heading {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 20px;
        }

        .visit-subheading {
            font-size: 20px;
            font-weight: bold;
            color: #374151;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .visit-form {
            margin-bottom: 20px;
        }

        .visit-search-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .visit-search-table td {
            padding: 8px;
        }

        .visit-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .visit-btn-primary {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .visit-btn-primary:hover {
            background-color: #0056b3;
        }

        .visit-btn-secondary {
            background-color: #e2e8f0;
            color: #1f2937;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .visit-btn-secondary:hover {
            background-color: #cbd5e1;
        }

        /* Table Styling */
        .visit-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .visit-table th,
        .visit-table td {
            border: 1px solid #e5e7eb;
            padding: 12px;
            text-align: left;
        }

        .visit-table th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #4b5563;
        }

        .visit-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .visit-table tr:hover {
            background-color: #eef2ff;
        }

        /* Select Dropdown */
        .visit-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        /* Error Message */
        .error-message {
            font-size: 14px;
            color: #dc3545;
            margin-bottom: 10px;
        }

        /* Visit Section */
        .visit-section {
            margin-top: 30px;
        }

        .visit-output {
            margin-top: 10px;
            font-size: 14px;
            color: #6b7280;
        }


    </style>

</head>
<body>


<div class="main">
    <?php echo $__env->yieldContent('content'); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
<?php echo \Livewire\Livewire::scripts(); ?>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    Livewire.on('parentUpdated', message => {

            location.reload();
        });
Livewire.on('closeModal', () => {
    // Close the modal using JavaScript (Bootstrap)
    $('#editParentModal').modal('hide');
    $('#editChildModal').modal('hide');
    $('#addChildModal').modal('hide');
});
Livewire.on('childUpdated', message => {

location.reload();
});
Livewire.on('childAdded', message => {

location.reload();
});
</script>

</body>
</html><?php /**PATH C:\Users\User\Downloads\Beacon\BeaconChildrenCenter\resources\views/reception/layout.blade.php ENDPATH**/ ?>