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

<style>

form {
    display: flex;
    flex-direction: column;
}

.add-event-body > div {
    margin-bottom: 10px; /* Add space between each input */
}


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
    <!-- Your calendar HTML and scripts go here -->

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

            <div class="add-event-wrapper hidden" id="modal-wrapper">  
            


            <form action="{{ route('appointments.store') }}" method="POST" class= "form-container" id="form-container" onsubmit="this.reset()">

            @csrf
                <div class="add-event-header">
                    <div class="title">Add Event</div>
                    <i class="fas fa-times close"></i>
                </div>

                
                <div class="add-event-body">
                    <div class="add-event-input">
                        <label for="event_name">Appointment Title</label> 
                        <input type="text" id="event_name" placeholder="Event Name" class="event_name" style="color: black !important; width:170px !important"></br>
                    </div>
                    <div class="d-flex align-items-center flex-column" id="child-search-bar" 
     x-data="{ 
         search: '', 
         results: [], 
         loading: false,
         timeout: null,
         abortController: null,
         fetchResults() {
             clearTimeout(this.timeout); // Clear previous timeout
             this.timeout = setTimeout(() => {
                 // Clear results immediately to prevent showing old data
                 this.results = [];
                 this.loading = true;

                 if (this.abortController) {
                     this.abortController.abort(); // Cancel any ongoing fetch request
                 }
                 this.abortController = new AbortController(); // Create a new AbortController for this request

                 if (this.search.length >= 1) {
                     fetch(`/search-children?query=${this.search}`, { signal: this.abortController.signal })
                         .then(response => response.json())
                         .then(data => {
                             this.results = data; // Update results with new data
                             this.loading = false;
                         })
                         .catch((error) => {
                             if (error.name !== 'AbortError') { // Ignore fetch abort errors
                                 this.results = []; // Clear results on other errors
                                 this.loading = false;
                             }
                         });
                 } else {
                     this.loading = false;
                 }
             }, 200); // Adjust debounce delay as needed
         }
     }" 
     x-init="fetchResults()">

    <label for="search-bar" style="color: black !important;">Search</label>

    <!-- Search Input -->
    <input type="search" id="search-bar" x-model="search" @input="fetchResults" class="form-control mb-2"
           placeholder="Search for a child" aria-label="Search" />

    <!-- Loading Indicator -->
    <div x-show="loading" class="loading-text" style="color: black; text-align: center; margin-bottom: 10px;">
    L O A D I N G <span class="dots"><span>.</span><span>.</span><span>.</span></span>
</div>


    <!-- Search Input and Label -->
    

    <!-- No Results Message -->
    <div x-show="noResults" style="color: red; text-align: center; margin-bottom: 10px;">No results found.</div>

    <!-- Results Display -->
<div x-show="results.length > 0" class="results-container"
     style="width: 350px; max-height: 300px; margin-left: 60px; overflow-y: auto; 
            background-color: #fff; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <ul style="color: #333; list-style-type: none; padding: 0; margin: 0;">
            <template x-for="result in results" :key="result.id">
                <li class="result-item py-3 px-4" 
                    style="border-bottom: 1px solid #f1f1f1; display: flex; align-items: center; transition: background-color 0.3s;">
                    <div style="flex: 1;">
                        <strong style="font-size: 16px; color: black;">Child Name:</strong> 
                        <span x-text="result.child_name" style="font-size: 14px; font-weight: 600;"></span><br>
                        <strong style="font-size: 16px; color: black;">Date of Birth:</strong> 
                        <span x-text="result.dob" style="font-size: 14px;"></span><br>
                        <strong style="font-size: 16px; color: black;">Parent Name:</strong> 
                        <span x-text="result.parent_name" style="font-size: 14px;"></span><br>
                        <strong style="font-size: 16px; color: black;">Email:</strong> 
                        <span x-text="result.email" style="font-size: 14px;"></span><br>
                        <strong style="font-size: 16px; color: black;">Phone:</strong> 
                        <span x-text="result.telephone || 'Not available'" style="font-size: 14px;"></span><br>
                    </div>
                    <div>
                        <input type="checkbox" :id="`child_id_${result.id}`" :value="result.id" class="checkbox-input" style="cursor: pointer; " />
                        <span style="font-size: 14px; margin-left: 8px;">Select</span>
                    </div>
                </li>
            </template>
        </ul>
    </div>

</div>


<br>

                    <!-- Appointment Time Inputs -->
                    <div class="add-event-input">
                        <label for="event_time_from">Appointment Starting Time</label><br>
                        <input type="time" id="event_time_from" placeholder="Event starting time" class="event_time_from" style = "color :black !important">
                    </div> <br>

                    <div class="add-event-input">
                        <label for="event_time_end">Appointment Ending Time</label><br>
                        <input type="time" id="event_time_end" placeholder="Event ending time" class="event_time_end" style = "color :black !important">
                    </div> </br>
                <!-- Updated Select Service Dropdown -->
                <div class="add-event-input">
                <label for="doctor_specialization">Select a Specialization:</label><br>
             
                <select name="doctor_specialization" id="doctor_specialization" class="form-control droopp" style="color: black !important;">
                <option value="" style="color: black !important; width:150px !important;">-- Select Specialization --</option>

                @if(is_iterable($doctorSpecializations)) 
                    @foreach($doctorSpecializations as $specialization)
                        <option value="{{ $specialization->id }}" style="color: black !important;">
                            {{ $specialization->specialization }}
                        </option>
                    @endforeach
                @elseif(is_object($doctorSpecializations))
                    <!-- Single specialization case -->
                    <option value="{{ $doctorSpecializations->id }}" style="color: black !important;">
                        {{ $doctorSpecializations->specialization }}
                    </option>
                @endif
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
            @csrf
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
            <button type="submit"  id ="submit-button" style="background-color: lightblue; color:white;">Save</button>
        </form>
    </div>
 
       
</div>


</div>
    </div>

    <script src="{{asset('js/calendar.js')}}"></script>
    <script src="{{asset('js/appointments.js')}}"></script>
    <script type="module" src="{{asset('js/specialization.js')}}"></script>
    <script src="{{asset('js/isDoctorAvailable.js')}}"></script>

 </div>



 <script>
    function fetchResults() {
        this.loading = true;
        fetch(`/search-children?query=${encodeURIComponent(this.search)}`)
            .then(response => response.json())
            .then(data => {
                this.results = data;
                this.loading = false;
            })
            .catch(() => {
                this.loading = false;
            });
    }
    


</script>

</body>
</html>