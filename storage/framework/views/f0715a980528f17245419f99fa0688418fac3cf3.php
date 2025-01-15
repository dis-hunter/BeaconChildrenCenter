<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo e(asset('css/calendar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/calendar_2.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Add jQuery and Timepicker JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    window.csrfToken = "<?php echo e(csrf_token()); ?>";
</script>

    <title>Calendar</title>
</head>

<style>

    /* Styling for the heading */
div h2 {
    margin: 0;
    font-size: 18px; /* Adjust size if needed */
}

/* Styling for the close button */
#close-modal {
    cursor: pointer;
    font-size: 20px; /* Slightly larger for visibility */
    font-weight: bold;
    color: black;
    background-color: transparent; /* No background */
    border: none;
    outline: none;
    transition: background-color 0.3s ease, color 0.3s ease; /* Smooth hover effect */
}

/* Hover effect for the close button */
#close-modal:hover {
    background-color: lightblue;
    color: white; /* Optional - for contrast */
    border-radius: 4px; /* Slightly rounded edges */
    padding: 2px 6px; /* Optional padding for better appearance */
}
    </style>
<body>






<div class="calendar-container">

    <div class="container">
        <div class="left">
            <div class="calendar">
                <div class="month">
                    <i class="fa fa-angle-left prev"></i>
                    <div class="date"></div>
                    <i class="fa fa-angle-right next"></i>
                </div>
                <div class="weekdays">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>
                <div class="days">
                    <!-- Days will be dynamically added using JS -->
                </div>
                <div class="goto-today">
                    <div class="goto">
                        <input type="text" placeholder="mm/yyyy" class="date-input">
                        <button class="goto-btn">go</button>
                    </div>
                    <button class="today-btn">today</button>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="today-date">
                <div class="event-day"></div>
                <div class="event-date"></div>
            </div>

            <div class="events" id="events-container">
                <!-- Events will be dynamically added here using JS -->

                

            </div>

            <div class="add-event-wrapper">

            <form action="<?php echo e(route('appointments.store')); ?>" method="POST">

            <?php echo csrf_field(); ?>
                <div class="add-event-header">
                    <div class="title">Add Event</div>
                    <i class="fas fa-times close"></i>
                </div>

                
                <div class="add-event-body">
                    <div class="add-event-input">
                        <label for="event_name">Appointment Title</label> 
                        <input type="text" id="event_name" placeholder="Event Name" class="event_name" style="color: black !important;"></br>
                    </div>
                   
                    <div>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('child-search-bar')->html();
} elseif ($_instance->childHasBeenRendered('5Ey8S45')) {
    $componentId = $_instance->getRenderedChildComponentId('5Ey8S45');
    $componentTag = $_instance->getRenderedChildComponentTagName('5Ey8S45');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('5Ey8S45');
} else {
    $response = \Livewire\Livewire::mount('child-search-bar');
    $html = $response->html();
    $_instance->logRenderedChild('5Ey8S45', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>

                    <!-- Appointment Time Inputs -->
                    <div class="add-event-input">
                        <label for="event_time_from">Appointment Starting Time</label><br>
                        <input type="time" id="event_time_from" placeholder="Event starting time" class="event_time_from">
                    </div>

                    <div class="add-event-input">
                        <label for="event_time_end">Appointment Ending Time</label><br>
                        <input type="time" id="event_time_end" placeholder="Event ending time" class="event_time_end">
                    </div>
                <!-- Updated Select Service Dropdown -->
                <div class="add-event-input">
                <label for="doctor_specialization">Select a Specialization:</label><br>
                <select name="doctor_specialization" id="doctor_specialization" style="color: black !important;">
                    <option value="" style="color: black !important;">-- Select Specialization --</option>
                    <?php $__currentLoopData = $doctorSpecializations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($specialization->id); ?>" style="color: black !important;"><?php echo e($specialization->specialization); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>


                                    <div id="specialist-container">
                    <label for="specialist">Select a Specialist:</label>
                    <select name="specialist" id="specialist" class="form-control"  style="color: black !important;">>
                        <option value="" style="color: black !important;">-- Select a doctor --</option>
                    </select>
                </div>

                <!-- Container for no specialists message -->
                <div id="no-specialists-message" style="color: red; display: none;">
                    We currently don't have any specialists for this specialization.
                </div>

                </div>
                <br>
                <br>
                <br><br> <br> <br> <br><br> <br> <br>
                <div class="add-event-footer">
                    <button class="add-event-btn" type="submit">Create Appointment</button>
                </div>

                </form>
            </div>

            <button class="add-event">
                <i class="fas fa-plus"></i>
            </button>

</div>



       
</div>

<div id="reschedule-modal" class="hidden" style= " position: fixed; /* Keeps it fixed on the screen */
  top: 0; /* Position it at the top */
  left: 50%;
  width: 70%;
  height: 1600px !important; /* Automatically adjust height based on content */
  max-height: 500px; /* Force the modal to expand to 500px (you can adjust this as needed) */
  overflow: auto; /* Allow scrolling if the content exceeds max height */
  border-radius: 5px;
  background-color: #lightblue;
  transform: translateX(-50%);
  transition: max-height 0.5s;
  z-index: 1000; /* Make sure it appears on top of other content */
  padding: 20px;">
    <div class="modal-content"  style="width: 100%; /* Set width */">
        <div style=" display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ccc; /* Optional for a neat divider */
">
        <h2>Reschedule Appointment</h2>
        <span id="close-modal" class="close">&times;</span>
        </div>
        <form id="reschedule-form"  style="background-color: #fff; /* White background */
border: 2px solid ; /* Light gray border */
border-radius: 8px; /* Rounded corners */
padding: 20px; /* Internal spacing */
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
width: 75%; /* Set width */
margin: 20px auto; /* Center form */">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="hidden-start-time" style="border: 1px solid black !important;">
            <input type="hidden" id="hidden-end-time"style="border: 1px solid black !important;">
            <label for="appointment-title">Title:</label> 
            <input type="text" id="appointment-title" name="title" required style="border: 1px solid black !important;">

            <label for="appointment-start-time">Start Time:</label> <br>
            <input type="time" id="appointment-start-time" name="start_time" required style="border: 1px solid black !important;">

            <label for="appointment-end-time">End Time:</label> </br>
            <input type="time" id="appointment-end-time" name="end_time" required style="border: 1px solid black !important;">

            <label for="newDate">Date:</label> </br>
            <input type="date" id="newDate" name="newDate" required style="border: 1px solid black !important;">
</br> </br>
            <button type="submit"   style="background-color: lightblue; color:white;">Save</button>
        </form>
    </div>
 
       
</div>


</div>
    </div>

    <script src="<?php echo e(asset('js/calendar.js')); ?>"></script>
    <script src="<?php echo e(asset('js/appointments.js')); ?>"></script>
    <script type="module" src="<?php echo e(asset('js/specialization.js')); ?>"></script>
    <script src="<?php echo e(asset('js/isDoctorAvailable.js')); ?>"></script>

 </div>





</body>
</html>
<?php /**PATH D:\github\BeaconChildrenCenter\resources\views/calendar.blade.php ENDPATH**/ ?>