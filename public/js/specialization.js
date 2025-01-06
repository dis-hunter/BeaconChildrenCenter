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

    // Get the text content from the div
    const dateText = document.querySelector(".event-date")?.textContent || "";

    // Convert it to a Date object (JavaScript will handle the parsing)
    const date = new Date(dateText);

    // Get the time offset in minutes for the East Africa Time (EAT) zone
    const timezoneOffset = 3 * 60; // EAT is UTC+3
    
    // Adjust the date by adding the timezone offset in milliseconds
    date.setMinutes(date.getMinutes() + timezoneOffset);
    
    // Format the date to 'YYYY-MM-DD'
    const formattedDate = date.toISOString().split('T')[0];
    

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
        addEventBtn.addEventListener("click", () => {
            addEventContainer.classList.toggle("active");
        });

        addEventCloseBtn.addEventListener("click", () => {
            addEventContainer.classList.remove("active");
        });
    }
    

    // Service Dropdown Change Event
    if (serviceDropdown && specialistDropdown && specialistContainer) {
        serviceDropdown.addEventListener("change", () => {
            const selectedService = serviceDropdown.value;

            // Clear existing options
            specialistDropdown.innerHTML = '<option value="">-- Select Specialist --</option>';

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
    
        // Get the selected checkbox by querying the checkbox with the class or id (specific to your case)
        const selectedChildCheckbox = document.querySelector('input[type="checkbox"]:checked[id^="child_id_"]');
        
        
            const selectedChildId = selectedChildCheckbox.value; // This will get the child_id from the selected checkbox
            console.log("Selected Child ID:", selectedChildId);
    
            const request = {
                appointment_title: document.getElementById("event_name")?.value || "",
                staff_id: document.getElementById("specialist")?.value || "",
                start_time: document.getElementById("event_time_from")?.value || "",
                end_time: document.getElementById("event_time_end")?.value || "",
                child_id: selectedChildId || "",  // Send the selected child_id here
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
                if (data && data.success) {
                    // Show success alert
                    alert("Appointment successfully created!");
                    addEventContainer.classList.remove("active");
            
                    // Close the form
                    const formModal = document.getElementById("form-modal");
                    if (formModal) {
                        formModal.style.display = "none"; // Hide the form/modal
                    }
            
                    // Refresh the appointments list
                    const selectedDate = document.getElementById("selected-date").value;
                    updateEvents(selectedDate); // Call function to refresh the event list
                } else {
                    // Ensure the error message exists before showing it
                    const errorMessage = data && data.message ? data.message : "An unknown error occurred"; // Fallback message
                    alert("Error: " + errorMessage);
            
                    // Optionally, keep the form open for corrections
                    console.error("Error:", errorMessage);
                }
            })
            .catch((error) => {
                // Handle network errors or unexpected issues
                alert("An unexpected error occurred: " + error.message || error);
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