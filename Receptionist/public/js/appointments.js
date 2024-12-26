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

    const specialists = {
        doctor: [
            { id: 1, name: "Dr. Jehova Wanyonyi" },
            { id: 2, name: "Dr. Kasongo One" },
        ],
        physiotherapist: [
            { id: 1, name: "Bien Masuati" },
            { id: 2, name: "Sean Live" },
        ],
        occupational_therapist: [
            { id: 1, name: "Teamo Mkenya" },
            { id: 2, name: "Mwizi Hatari" },
        ],
        speech_therapist: [
            { id: 1, name: "Dr. Wa Riveroad" },
            { id: 2, name: "Dr. Black" },
        ],
        psychotherapist: [
            { id: 1, name: "Dr. Msumbufu" },
            { id: 2, name: "Dr. Love" },
        ],
        nutritionist: [
            { id: 1, name: "Mauano" },
            { id: 2, name: "Cheps" },
        ],
    };

    // Show/hide form
    if (addEventBtn && addEventContainer && addEventCloseBtn) {
        addEventBtn.addEventListener("click", () => {
            addEventContainer.classList.toggle("active");
        });

        addEventCloseBtn.addEventListener("click", () => {
            addEventContainer.classList.remove("active");
        });
    }

    // Service selection
    if (serviceDropdown && specialistDropdown && specialistContainer) {
        serviceDropdown.addEventListener("change", () => {
            const selectedService = serviceDropdown.value;

            specialistDropdown.innerHTML = '<label for="select">Select a specialist</label> <option value="" id="select">-- Select Specialist --</option>';
            if (specialists[selectedService]) {
                specialistContainer.style.display = "block";
                specialists[selectedService].forEach((specialist) => {
                    const option = document.createElement("option");
                    option.value = specialist.id;
                    option.textContent = specialist.name;
                    specialistDropdown.appendChild(option);
                });
                bookAppointmentBtn.style.display = "block"; // Show "Book Appointment" button when service is selected
            } else {
                specialistContainer.style.display = "none";
                bookAppointmentBtn.style.display = "none"; // Hide "Book Appointment" button if no specialists
            }
        });
    }

    // Add Event (Create appointment)
    if (addEventsSubmit && addEventTitle && addEventFrom && addEventTo) {
        addEventsSubmit.addEventListener("click", () => {
            const eventTitle = addEventTitle.value;
            const eventTimeFrom = addEventFrom.value;
            const eventTimeTo = addEventTo.value;

            if (eventTitle === "" || eventTimeFrom === "" || eventTimeTo === "") {
                alert("Please fill all fields for the appointment");
                return;
            }

            const newEvent = {
                title: eventTitle,
                time: `${eventTimeFrom} - ${eventTimeTo}`,
            };

            let eventExists = false;
            eventsArr.forEach((eventObj) => {
                if (
                    eventObj.day === activeDay &&
                    eventObj.month === month + 1 &&
                    eventObj.year === year
                ) {
                    eventObj.events.push(newEvent);
                    eventExists = true;
                }
            });

            if (!eventExists) {
                eventsArr.push({
                    day: activeDay,
                    month: month + 1,
                    year: year,
                    events: [newEvent],
                });
            }

            addEventContainer.classList.remove("active");
            addEventTitle.value = "";
            addEventFrom.value = "";
            addEventTo.value = "";

            updateEvents(activeDay);
        });
    }
});

function bookAppointment(dayElement) {
    // Add the 'event-booked' class to the clicked day element
    dayElement.classList.add("event-booked");
    // Show the form by adding the 'active' class
    document.querySelector('.add-event-wrapper').classList.add('active');
}
