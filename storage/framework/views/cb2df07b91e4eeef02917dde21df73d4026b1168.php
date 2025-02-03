
<?php $__env->startSection('title','Appontments | Reception'); ?>

<?php $__env->startSection('content'); ?>

<style>
.cancel-btn,
.reschedule-btn {
    background-color: white !important;
    color: black !important;
}

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
<<<<<<< HEAD
=======
    /*margin-left: 200px !important;*/
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef
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
<<<<<<< HEAD
=======
.results-container {
    margin-left: 200px !important; /* Override original CSS */
}
>>>>>>> 9f59704b61ecc3c1d2b0d4bfb22dc084059bdbef

</style>
<div class="w-100">
 <?php echo $__env->make('calendar', ['doctorSpecializations' => $doctorSpecializations ?? []], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('reception.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('reception.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\BeaconChildrenCenter\resources\views/reception/reception_calendar.blade.php ENDPATH**/ ?>