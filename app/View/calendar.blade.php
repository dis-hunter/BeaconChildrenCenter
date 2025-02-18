<!-- resources/views/calendar.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar_2.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Calendar</title>
</head>
<body>
    <div class="calendar-container">
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
                        <input type="text" id="event_name" placeholder="Event Name" class="event_name" style="color: black !important;">
                    </div>
                    <div>
                        @livewire('child-search-bar')
                    </div>
                    <div class="add-event-input">
                        <label for="event_time_from">Appointment Starting Time</label>
                        <input type="time" id="event_time_from" name="event_time_from" required>
                    </div>
                    <div class="add-event-input">
                        <label for="event_time_end">Appointment Ending Time</label>
                        <input type="time" id="event_time_end" name="event_time_end" required>
                    </div>
                    <div class="add-event-footer">
                        <button class="add-event-btn" type="submit">Create Appointment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/calendar.js') }}"></script>
    <script src="{{ asset('js/appointments.js') }}"></script>
    <script type="module" src="{{ asset('js/specialization.js') }}"></script>
</body>
</html>