
<?php $__env->startSection('title', 'Visits | Reception'); ?>

<head>
    <link href="<?php echo e(asset('css/calendar.css')); ?>" rel="stylesheet">
</head>

<style>
/* Ensure the parent container takes full height of the viewport */
body, html {
    height: 100%;
    margin: 0;
}

/* Make sure the main container fills the entire viewport */
.main-container {
    display: flex;
    flex-direction: column;

}

/* Calendar container should occupy all remaining space in its parent */
.calendar-container {
    flex: 1; /* Makes it take up all available space */
/* Allow scrolling if the content overflows */
margin-top: 80px; /* Optional padding */
    box-sizing: border-box; /* Ensure padding is included in the element's total width/height */
}

/* Optional: to ensure calendar is responsive and doesn't overflow the container */
.calendar-container {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
} 
.cancel-btn,
.reschedule-btn {
    background-color: white !important;
    color: black !important;
}
/* Style the search bar */
#search-bar {
    width: 250px !important;
    margin-left: 220px; /* Make the search bar take up the full width of its container */
    height :30px !important;
    max-width: 500px; /* Limit the maximum width */
    padding: 15px; /* Increase padding for a larger search bar */
    font-size: 18px; /* Set a larger font size */
    color: black; /* Set the text color to black */
    border: 2px solid #ccc; /* Light border around the search bar */
    border-radius: 5px; /* Rounded corners */
    background-color: #f9f9f9; /* Light background color */
    box-sizing: border-box; /* Include padding and border in width calculation */
}

/* Optional: Add focus styles for better interaction */
#search-bar:focus {
    outline: none; /* Remove default outline */
    border-color: #007bff; /* Change border color when focused */
    background-color: #fff; /* Change background when focused */
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 100%; /* Ensures it dynamically occupies the width of the parent container */
    max-width: 500px; /* Optional: Limit the max width if necessary */
    background: white;
    z-index: 10;
    border: 1px solid #ddd;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 10px;
}

.result-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.result-item:nth-child(even) {
    background-color: #f9f9f9;
}

.result-item:nth-child(odd) {
    background-color: #ffffff;
}



</style>

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php echo \Livewire\Livewire::scripts(); ?>

    <div class="calendar-container">
    <?php echo $__env->make('calendar', ['doctorSpecializations' => $doctorSpecializations ?? []], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Assuming calendar.blade.php is outside the reception folder -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/reception/reception_calendar.blade.php ENDPATH**/ ?>