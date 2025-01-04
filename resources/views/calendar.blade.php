<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar_2.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Add jQuery and Timepicker JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    window.csrfToken = "{{ csrf_token() }}";
</script>

    <title>Calendar</title>
</head>
<body>
@livewireScripts

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

            <form action="{{ route('appointments.store') }}" method="POST">

            @csrf
                <div class="add-event-header">
                    <div class="title">Add Event</div>
                    <i class="fas fa-times close"></i>
                </div>

                
                <div class="add-event-body">
                    <div class="add-event-input">
                        <label for="event_name">Appointment Title</label> 
                        <input type="text" id="event_name" placeholder="Event Name" class="event_name"></br>
                    </div>
                   
                    <div>
                    @livewire('child-search-bar')
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
                        <select name="doctor_specialization" id="doctor_specialization">
                            <option value="">-- Select Specialization --</option>
                            @foreach($doctorSpecializations as $specialization)
                                <option value="{{ $specialization->id }}">{{ $specialization->specialization }}</option>
                            @endforeach
                        </select>
                    </div>

                                    <div id="specialist-container">
                    <label for="specialist">Select a Specialist:</label>
                    <select name="specialist" id="specialist" class="form-control">
                        <option value="">-- Select a doctor --</option>
                    </select>
                </div>

                <!-- Container for no specialists message -->
                <div id="no-specialists-message" style="color: red; display: none;">
                    We currently don't have any specialists for this specialization.
                </div>

                </div>
                <div class="add-event-footer">
                    <button class="add-event-btn" type="submit">Create Appointment</button>
                </div>

                </form>
            </div>

            <button class="add-event">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div id="reschedule-modal" class="hidden">
            
            <div class="modal-content">
                <span id="close-modal" class="close">&times;</span>
                <h2>Reschedule Appointment</h2>
                <form id="reschedule-form">
                @csrf
                    <input type="hidden" id="hidden-start-time">
                    <input type="hidden" id="hidden-end-time">
                    <label for="appointment-title">Title:</label>
                    <input type="text" id="appointment-title" name="title" required>

                    <label for="appointment-start-time">Start Time:</label>
                    <input type="time" id="appointment-start-time" name="start_time" required>

                    <label for="appointment-end-time">End Time:</label>
                    <input type="time" id="appointment-end-time" name="end_time" required>

                    <label for="newDate">Date:</label>
                    <input type="date" id="newDate" name="newDate" required>

                    <button type="submit">Save</button>
                </form>
            </div>
        </div>
       
</div>

</div>
    </div>

    <script src="{{asset('js/calendar.js')}}"></script>
    <script src="{{asset('js/appointments.js')}}"></script>
    <script src="{{asset('js/specialization.js')}}"></script>
    <script src="{{asset('js/isDoctorAvailable.js')}}"></script>


    
</body>
</html>
