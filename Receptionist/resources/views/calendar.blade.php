<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Calendar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .left {
            width: 70%;
        }

        .right {
            width: 28%;
            padding-left: 20px;
        }

        .add-event-wrapper {
            display: none;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow-y: auto;
            max-height: 600px;
            width: 100%;
        }

        .add-event-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.4em;
            font-weight: bold;
            margin-bottom: 20px;
            color: black;
        }

        .add-event-header .close {
            font-size: 1.6em;
            cursor: pointer;
            color: black;
        }

        .add-event-body {
            display: flex;
            flex-direction: column;
        }

        .add-event-input {
            margin-bottom: 20px;
        }

        .add-event-input label {
            display: block;
            font-weight: normal;
            margin-bottom: 10px;
            font-size: 1.1em;
            color: #333;
        }

        .add-event-input input,
        .add-event-input select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1.1em;
            box-sizing: border-box;
        }

        .add-event-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .add-event-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 6px;
            font-size: 1.1em;
        }

        .add-event-btn:hover {
            background-color: #0056b3;
        }

        .add-event {
            background-color: #007bff;
            border: none;
            border-radius: 50%;
            padding: 18px;
            cursor: pointer;
            position: fixed;
            bottom: 30px;
            right: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        /* Style for input fields to make them larger */
.add-event-body input[type="text"], 
.add-event-body input[type="date"], 
.add-event-body input[type="number"], 
.add-event-body select {
    width: 250px !important;        /* Makes the input span the full width of its container */
    height: 40px;       /* Adjust the height of the input box */
    padding: 10px;      /* Adds padding inside the input box */
    font-size: 16px;    /* Increases the font size for better readability */
    border: 2px solid #ccc; /* Light gray border */
    border-radius: 4px; /* Rounded corners */
    box-sizing: border-box; /* Ensures padding is included in the element's total width/height */

    display: block;         /* Forces each element to take up a full line */
             /* Makes the input span the full width of its container */
    margin: 5px;    /* Adds space below each input box */
}

/* Style for input boxes */
.add-event-body input[type="text"],
.add-event-body input[type="date"],
.add-event-body input[type="time"],
.add-event-body input[type="number"],
.add-event-body select {
    height: 40px;           /* Adjust the height of the input box */
    padding: 10px;          /* Adds padding inside the input box */
    font-size: 16px;        /* Increases the font size for better readability */
    border: 2px solid #ccc; /* Light gray border */
    border-radius: 4px;     /* Rounded corners */
    box-sizing: border-box; /* Ensures padding is included in the element's total width/height */
}



        .add-event i {
            color: white;
            font-size: 28px;
        }

        .add-event-wrapper.active {
            display: block;
        }

        .appointment-form select {
            font-size: 1.1em;
            padding: 12px;
            margin-top: 10px;
        }

        input[type="time"] {
            padding: 14px;
            font-size: 1.1em;
        }

        /* Specialist section styling */
        #specialist-container {
            margin-top: 20px;
        }

        /* Underlined dates based on specialist */
        .calendar .days .day {
            position: relative;
        }

        .calendar .days .day.underlined {
            text-decoration: underline;
            font-weight: bold;
            color: #007bff;
        }

        /* Color based on specialist */
        .calendar .days .day.occupational_therapist {
            color: green;
        }

        .calendar .days .day.speech_therapist {
            color: orange;
        }

        .calendar .days .day.psychotherapist {
            color: purple;
        }

        .calendar .days .day.nutritionist {
            color: red;
        }

        .calendar .days .day.physiotherapist {
            color: blue;
        }

        .calendar .days .day.doctor {
            color: teal;
        }
        label{
            width:100% !important;
            display:block !important;
        }


    </style>
</head>
<body>
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
                <div class="event-day">Mon</div>
                <div class="event-date">23 December 2024</div>
            </div>

            <div class="events">
                <!-- Events will be dynamically added here using JS -->
            </div>

            <div class="add-event-wrapper">
                <div class="add-event-header">
                    <div class="title">Add Event</div>
                    <i class="fas fa-times close"></i>
                </div>
                <div class="add-event-body">
                    <div class="add-event-input">
                        <label for="event_name">Appointment Title</label> 
                        <input type="text" id="event_name" placeholder="Event Name" class="event_name"></br>
                    </div>
                    <div class="add-event-input">
                        <label for="patient_name">Patient Name</label> 
                        <input type="text" id="patient_name" placeholder="Patient Name" class="patient_name"></br>
                    </div>
                    <div class="add-event-input">
                        <label for="patient_contact">Patient contact</label> 
                        <input type="text" id="patient_contact" placeholder="Patient Contact" class="patient_contact"></br>
                    </div>
                    <div class="add-event-input">
                        <label for="patient_email">Patient email</label> 
                        <input type="email" id="patient_email" placeholder="Patient email" class="patient_email" style="size :300px"></br>
                    </div>

                    <div class="add-event-input">
                        <label for="event_time_from">Appointment Starting Time</label> </br>
                        <input type="time" id="event_time_from" placeholder="Event starting time" class="event_time_from"></br>
                    </div>
                    <div class="add-event-input">
                        <label for="event_time_end">Appointment Ending Time</label></br> <br>
                        <input type="time" id="event_time_end" placeholder="Event ending time" class="event_time_end"></br>
                    </div>
                    <div class="add-event-input">
                        <label for="service">Select a Service:</label></br>
                        <select name="service" id="service">
                            <option value="">-- Select Service --</option>
                            <option value="doctor">Doctor</option>
                            <option value="physiotherapist">Physiotherapist</option>
                            <option value="occupational_therapist">Occupational Therapist</option>
                            <option value="speech_therapist">Speech Therapist</option>
                            <option value="psychotherapist">Psychotherapist</option>
                            <option value="nutritionist">Nutritionist</option>
                        </select>
                    </div>
                    <div id="specialist-container"></br>
                        <label for="specialist">Select a Specialist:</label>
                        <select name="specialist" id="specialist">
                            <option value="">-- Select Specialist --</option>
                        </select>
                    </div>
                </div>
                <div class="add-event-footer">
                    <button class="add-event-btn">Create Appointment</button>
                </div>
            </div>

            <button class="add-event">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <script src="{{asset('js/calendar.js')}}"></script>
    <script src="{{asset('js/appointments.js')}}"></script>
</body>
</html>
