//import { updateEvents } from './calendar.js';
document.addEventListener("DOMContentLoaded", function () {
    const addEventBtn = document.querySelector(".add-event");
    const addEventContainer = document.querySelector(".add-event-wrapper");
    const addEventCloseBtn = document.querySelector(".close");
    const addEventTitle = document.querySelector(".event_name");
    const addEventFrom = document.querySelector(".event_time_from");
    const addEventTo = document.querySelector(".event_time_end");
    const addEventsSubmit = document.querySelector(".add-event-btn");

    const serviceDropdown = document.getElementById("service");
    const specialistContainer = document.getElementById("specialist-container");
    const specialistDropdown = document.getElementById("specialist");
    const bookAppointmentBtn = document.getElementById("book-appointment");

    let formattedDate = ""; // Store the dynamically updated formatted date
    

    // Function to update the formatted date when the event date changes
    function updateFormattedDate() {
        const dateText = document.querySelector(".event-date")?.textContent.trim() || "";

        if (!dateText) return;

        const date = new Date(dateText);
        if (isNaN(date)) return; // Ignore invalid dates

        const timezoneOffset = 3 * 60; // EAT (UTC+3)
        date.setMinutes(date.getMinutes() + timezoneOffset);

        formattedDate = date.toISOString().split("T")[0];
        console.log("Updated formatted date:", formattedDate);
    }

    // Initial call to set formattedDate when the page loads
    updateFormattedDate();

    // Observe changes to the event date element
    const eventDateElement = document.querySelector(".event-date");
    if (eventDateElement) {
        const observer = new MutationObserver(updateFormattedDate);
        observer.observe(eventDateElement, { childList: true, subtree: true });
    }


    const checkDoctorAvailability = () => {
        const doctorId = specialistDropdown?.value;
        const datePicker = document.getElementById("event_date");
        const timeStart = document.getElementById("event_time_from")?.value;
        const timeEnd = document.getElementById("event_time_end")?.value;

        if (doctorId && datePicker?.value && timeStart && timeEnd) {
            fetch(`/check-availability?doctor_id=${doctorId}&date=${datePicker.value}&start_time=${timeStart}&end_time=${timeEnd}`)
                .then((response) => response.json())
                .then((data) => {
                    if (!data.available) {
                        alert("Doctor is unavailable during this time. Please select a different time.");
                    }
                })
                .catch((error) => {
                    console.error("Error checking doctor availability:", error);
                });
        } else {
            console.warn("Missing required fields for availability check.");
        }
    };

    // Dropdown Change Event for Specialization
    $(document).ready(function () {
        $('#doctor_specialization').change(function () {
            const specializationId = $(this).val(); // Get the selected specialization ID
            const specialistSelect = $('#specialist');
            const specialistContainer = $('#specialist-container');
            const noSpecialistsMessage = $('#no-specialists-message'); // Add this element to display the message

            // Clear the specialist dropdown and reset it
            specialistSelect.empty();
            specialistSelect.append('<option value="">-- Select Specialist --</option>');

            // Hide the specialist container and message by default
            specialistContainer.hide();
            noSpecialistsMessage.hide();

            if (specializationId) {
                // Show the specialist dropdown
                specialistContainer.show();

                // Fetch doctors based on the selected specialization
                $.ajax({
                    url: `/get-doctors/${specializationId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log('Doctors data:', data); // Log the response

                        if (data.message) {
                            noSpecialistsMessage.text(data.message).show();
                        } else if (data.length > 0) {
                            data.forEach(function (doctor) {
                                specialistSelect.append(`<option value="${doctor.id}">${doctor.full_name}</option>`);
                            });
                            noSpecialistsMessage.hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching doctors:', error);
                        console.error('Response:', xhr.responseText);
                        alert('An error occurred while fetching doctors.');
                        console.log(error)
                    }
                });
            }
        });
    });

    // Show/Hide Add Event Form
    if (addEventBtn && addEventContainer && addEventCloseBtn) {
        document.addEventListener("click", function (event) {
            // Open the "Add Event" modal
            if (event.target.classList.contains("add-event")) {
                document.querySelector(".add-event-wrapper")?.classList.add("active");
            }
        
            // Close the modal
            if (event.target.classList.contains("close")) {
                document.querySelector(".add-event-wrapper")?.classList.remove("active");
            }
        });
        
        
    }
    

    // Service Dropdown Change Event
    if (serviceDropdown && specialistDropdown && specialistContainer) {
        serviceDropdown.addEventListener("change", () => {
            const selectedService = serviceDropdown.value;

            // Clear existing options
            specialistDropdown.innerHTML = '<option value="" class= "dropper">-- Select Specialist --</option>';

            if (selectedService) {
                fetch(`/api/specialists?service=${selectedService}`)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.length > 0) {
                            specialistContainer.style.display = "block";
                            data.forEach((specialist) => {
                                const option = document.createElement("option");
                                option.value = specialist.id;
                                option.textContent = specialist.name;
                                specialistDropdown.appendChild(option);
                            });
                        } else {
                            specialistContainer.style.display = "none";
                            alert("No specialists found for the selected service.");
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching specialists:", error);
                        alert("An error occurred while fetching specialists.");
                    });
            } else {
                specialistContainer.style.display = "none";
            }
        });

        // Specialist Dropdown Change Event
        specialistDropdown?.addEventListener("change", checkDoctorAvailability);
    }
    

    addEventsSubmit?.addEventListener("click", function (event) {
        event.preventDefault();
    
        // Create a spinner container and append to body
        const spinnerContainer = document.createElement("div");
        spinnerContainer.classList.add("spinner-container");
    
        const spinner = document.createElement("div");
        spinner.classList.add("l-spinner");
    
        // Add the text "Creating Appointment..."
        const spinnerText = document.createElement("span");
        spinnerText.textContent = "Creating Appointment...";
        spinnerText.classList.add("spinner-text");
    
        spinnerContainer.appendChild(spinner);
        spinnerContainer.appendChild(spinnerText);
        document.body.appendChild(spinnerContainer); // Show the loader
    
        // Get the selected checkbox by querying the checkbox with the class or id
        const selectedChildCheckbox = document.querySelector('input[type="checkbox"]:checked[id^="child_id_"]');
        const selectedChildId = selectedChildCheckbox ? selectedChildCheckbox.value : null;
    
        const request = {
            appointment_title: document.getElementById("event_name")?.value || "",
            staff_id: document.getElementById("specialist")?.value || "",
            start_time: document.getElementById("event_time_from")?.value || "",
            end_time: document.getElementById("event_time_end")?.value || "",
            child_id: selectedChildId,
            appointment_date: formattedDate,
            doctor_id: 2, // Example, adjust as needed
            status: "pending",
        };
        

    
        fetch("http://127.0.0.1:8000/appointments", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(request),
        })
            .then((response) => response.json())
            .then((data) => {
                document.body.removeChild(spinnerContainer); // Remove the loader
                if (data && data.success) {
                    alert("Appointment successfully created!");
                    addEventContainer.classList.remove("active");
    
                    const formModal = document.getElementById("form-modal");
                    if (formModal) {
                        formModal.style.display = "none"; // Hide the form/modal
                    }
    
                    window.updateEvents(request.appointment_date);
                } else {
                    const errorMessage = data && data.message ? data.message : "An unknown error occurred";
                    alert("Error: " + errorMessage);
                    console.error("Error:", errorMessage);
                }
            })
            .catch((error) => {
                document.body.removeChild(spinnerContainer); // Remove the loader
                alert("An unexpected error occurred: " + (error.message || error));
                console.error("Error:", error);
            });
    
    
            
            console.log('request data',request);
        
    });
    console.log('Trying to get CSRF token...');
const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
console.log('Element found:', csrfTokenMeta);

if (csrfTokenMeta) {
    const csrfToken = csrfTokenMeta.getAttribute('content');
    console.log('CSRF Token:', csrfToken);
} else {
    console.error('CSRF token meta tag not found');
}

    
    });

    export function handleAddEventListeners() {
        // Cache the wrapper for efficiency
        const addEventWrapper = document.querySelector(".add-event-wrapper");
    
        if (!addEventWrapper) {
            console.warn("Add Event wrapper not found!");
            return;
        }
    
        // Add click listeners for "Add Event" and "Close" buttons
        document.addEventListener("click", function (event) {
            // Open the Add Event modal
            if (event.target.classList.contains("add-event")) {
                console.log("Opening Add Event modal...");
                addEventWrapper.classList.add("active");
            }
    
            // Close the Add Event modal
            if (event.target.classList.contains("close")) {
                console.log("Closing Add Event modal...");
                addEventWrapper.classList.remove("active");
            }
        });
    }
    