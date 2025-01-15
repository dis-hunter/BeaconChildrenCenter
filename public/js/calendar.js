const calendar = document.querySelector(".calendar"),
    date = document.querySelector(".date"),
    daysContainer = document.querySelector(".days"),
    prev = document.querySelector(".prev"),
    next = document.querySelector(".next"),
    todayBtn = document.querySelector(".today-btn"),
    gotoBtn = document.querySelector(".goto-btn"),
    dateInput = document.querySelector(".date-input"),
    eventDay = document.querySelector(".event-day"),
    eventDate = document.querySelector(".event-date"),
    eventsContainer = document.querySelector(".events");

let today = new Date();
let activeDay;
let month = today.getMonth();
let year = today.getFullYear();

const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
];

// Default events array
const eventsArr = [
    {
        day: 13,
        month: 11,
        year: 2022,
        events: [
            {
                title: "Event 1: Appointment with Jehova Wanyonyi",
                time: "10:00",
            },
            {
                title: "Event 2: Appointment with Santa",
                time: "11:00",
            },
        ],
    },
];

function initCalendar() {
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const prevLastDay = new Date(year, month, 0);
    const prevDays = prevLastDay.getDate();
    const lastDate = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    const lastDayIndex = lastDay.getDay();
    const nextDays = 7 - lastDayIndex - 1;

    date.innerHTML = `${months[month]} ${year}`;

    let days = "";

    // Previous month days
    for (let x = firstDayIndex; x > 0; x--) {
        days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
    }

    // Current month days
    for (let i = 1; i <= lastDate; i++) {
        let event = false;
        eventsArr.forEach((eventObj) => {
            if (
                eventObj.day === i &&
                eventObj.month === month + 1 &&
                eventObj.year === year
            ) {
                event = true;
            }
        });

        if (
            i === today.getDate() &&
            year === today.getFullYear() &&
            month === today.getMonth()
        ) {
            activeDay = i;
            getActiveDay(i);
            updateEvents(i);

            if (event) {
                days += `<div class="day today active event">${i}</div>`;
            } else {
                days += `<div class="day today active">${i}</div>`;
            }
        } else {
            if (event) {
                days += `<div class="day event">${i}</div>`;
            } else {
                days += `<div class="day">${i}</div>`;
            }
        }
    }

    // Next month days
    for (let j = 1; j <= nextDays; j++) {
        days += `<div class="day next-date">${j}</div>`;
    }

    daysContainer.innerHTML = days;
    addlistener();
}

// Navigation
function prevMonth() {
    month--;
    if (month < 0) {
        month = 11;
        year--;
    }
    initCalendar();
}

function nextMonth() {
    month++;
    if (month > 11) {
        month = 0;
        year++;
    }
    initCalendar();
}

// Event Listeners
prev.addEventListener("click", prevMonth);
next.addEventListener("click", nextMonth);

todayBtn.addEventListener("click", () => {
    today = new Date();
    month = today.getMonth();
    year = today.getFullYear();
    initCalendar();
});

dateInput.addEventListener("input", (e) => {
    dateInput.value = dateInput.value.replace(/[^0-9/]/g, "");
    if (dateInput.value.length === 2) {
        dateInput.value += "/";
    }
    if (dateInput.value.length > 7) {
        dateInput.value = dateInput.value.slice(0, 7);
    }
});

gotoBtn.addEventListener("click", gotoDate);

function gotoDate() {
    const dateArr = dateInput.value.split("/");
    if (dateArr.length === 2) {
        if (dateArr[0] > 0 && dateArr[0] < 13 && dateArr[1].length === 4) {
            month = dateArr[0] - 1;
            year = parseInt(dateArr[1]);
            initCalendar();
            return;
        }
    }
    alert("Invalid Date");
}

function addlistener() {
    const days = document.querySelectorAll(".day");
    days.forEach((day) => {
        day.addEventListener("click", (e) => {
            activeDay = Number(e.target.innerHTML);
            getActiveDay(activeDay);
            updateEvents(activeDay);

            days.forEach((day) => {
                day.classList.remove("active");
            });

            if (e.target.classList.contains("prev-date")) {
                prevMonth();
            } else if (e.target.classList.contains("next-date")) {
                nextMonth();
            } else {
                e.target.classList.add("active");
            }
        });
    });
}

function getActiveDay(date) {
    const day = new Date(year, month, date);
    const dayName = day.toString().split(" ")[0];
    eventDay.innerHTML = dayName;
    eventDate.innerHTML = `${date} ${months[month]} ${year}`;
}
/*
function updateEvents(date) {
    let events = "";
    eventsArr.forEach((event) => {
        if (
            event.day === date &&
            event.month === month + 1 &&
            event.year === year
        ) {
            event.events.forEach((event) => {
                events += `<div class="event">
                    <div class="title">
                        <i class="fas fa-circle"></i>
                        <h3 class="event-title">${event.title}</h3>
                    </div>
                    <div class="event-time">
                        <span>${event.time}</span>
                    </div>

                    
                </div>`;
            });
        }
    });

    if (events === "") {
        events = `<div class="no-event"><h3>No Events</h3></div>`;
    }

    eventsContainer.innerHTML = events;
}*/
function updateEvents(date) {
    const eventsContainer = document.getElementById("events-container");

    // Clear the container to remove any previous events
    eventsContainer.innerHTML = "";

    // Ensure the container is visible
    eventsContainer.style.display = "block";

    // Fetch appointments for the selected date
    fetch(`/get-appointments?date=${date}`)
        .then((response) => response.json())
        .then((appointments) => {
            if (appointments && appointments.length > 0) {
                appointments.forEach((appointment) => {
                    // Parse the parent_name JSON string
                    let formattedParentName = "N/A";
                    try {
                        const parentName = JSON.parse(appointment.parent_name);
                        formattedParentName = `${parentName.first_name} ${parentName.middle_name} ${parentName.last_name}`;
                        const childrenName = JSON.parse(appointment.child_name);
                        formattedChildName = `${childrenName.first_name} ${childrenName.middle_name} ${childrenName.last_name}`;
                        const staffName = JSON.parse(appointment.staff_name);
                        formattedStaffName = `${staffName.first_name} ${staffName.middle_name} ${staffName.last_name}`;
                    
                    
                    
                    } catch (error) {
                        console.error("Error parsing parent_name:", appointment.parent_name);
                    }

                    // Create the appointment event HTML
                    const eventDiv = document.createElement("div");
                    eventDiv.classList.add("event");

                    eventDiv.innerHTML = `
                        <div class="title">
                            <i class="fas fa-circle"></i>
                            <h3 class="event-title">${appointment.appointment_title || "Untitled Appointment"}</h3>
                        </div>
                        <div class="event-time">
                            <span>${appointment.start_time} - ${appointment.end_time}</span>
                        </div>
                        <div>
                            <p><strong>With:</strong> ${formattedStaffName}</p>
                        </div>
                        <div class="parent-details">
                            <p><strong>Child name:</strong>${formattedChildName} </p>
                            <p><strong>Parent:</strong> ${formattedParentName}</p>
                            <p><strong>Phone:</strong> ${appointment.parent_phone}</p>
                            <p><strong>Email:</strong> ${appointment.parent_email}</p>
                        </div>
                        <button class="cancel-btn" data-id="${appointment.appointmentId}">Cancel</button>
                        <button class="reschedule-btn" 
                            data-id="${appointment.appointmentId}" 
                            data-title="${appointment.appointment_title}" 
                            data-start-time="${appointment.start_time}" 
                            data-end-time="${appointment.end_time}" 
                            data-appointment-date="${appointment.appointment_date}">Reschedule</button>
                    `;

                    // Append the event div to the container
                    eventsContainer.appendChild(eventDiv);

                    // Add cancellation functionality
                    const cancelButton = eventDiv.querySelector(".cancel-btn");
                    cancelButton.addEventListener("click", (e) => {
                        const appointmentId = e.target.getAttribute("data-id");

                        if (confirm("Are you sure you want to cancel this appointment?")) {
                            const csrfToken = document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content");

                            fetch(`/cancel-appointment/${appointmentId}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": csrfToken,
                                    "Content-Type": "application/json",
                                },
                            })
                                .then((response) => {
                                    if (response.ok) {
                                        alert("Appointment canceled successfully.");
                                        updateEvents(date);
                                    } else {
                                        return response.json().then((data) => {
                                            throw new Error(
                                                data.message ||
                                                    "Failed to cancel appointment."
                                            );
                                        });
                                    }
                                })
                                .catch((error) => {
                                    console.error("Error canceling appointment:", error);
                                    alert(
                                        "An error occurred while canceling the appointment."
                                    );
                                });
                        }
                    });
                });
            } else {
                const noEventDiv = document.createElement("div");
                noEventDiv.classList.add("no-event");
                noEventDiv.innerHTML = `<h3>No Appointments for this day</h3>`;
                eventsContainer.appendChild(noEventDiv);
            }
        })
        .catch((error) => {
            console.error("Error fetching appointments:", error);
        });

   

    // Handle reschedule button clicks
    eventsContainer.addEventListener("click", (e) => {
        if (e.target.classList.contains("reschedule-btn")) {
            const rescheduleModal = document.getElementById("reschedule-modal");
            const rescheduleForm = document.getElementById("reschedule-form");

            const appointmentId = e.target.getAttribute("data-id");
            const title = e.target.getAttribute("data-title");
            const startTime = e.target.getAttribute("data-start-time");
            const endTime = e.target.getAttribute("data-end-time");
            const appointmentDate = e.target.getAttribute("data-appointment-date");

            // Autofill the form with event data
            document.getElementById("appointment-title").value = title;
            document.getElementById("appointment-start-time").value = startTime;
            document.getElementById("appointment-end-time").value = endTime;
            document.getElementById("newDate").value = appointmentDate;

            // Set hidden startTime and endTime
            document.getElementById("hidden-start-time").value = startTime;
            document.getElementById("hidden-end-time").value = endTime;

            // Add appointmentId as a dataset property to the form
            rescheduleForm.dataset.appointmentId = appointmentId;

            // Show the modal
            rescheduleModal.classList.remove("hidden");

            // Close modal on cancel
            document
                .getElementById("close-modal")
                .addEventListener("click", () => {
                    rescheduleModal.classList.add("hidden");
                });
        }
    });

    // Handle Reschedule Form Submission
    document
    .getElementById("reschedule-form")
    .addEventListener("submit", function (e) {
        e.preventDefault();

        const newDate = document.getElementById("newDate").value;
        const startTime = document.getElementById("appointment-start-time").value;
        const endTime = document.getElementById("appointment-end-time").value;
        const appointmentId = this.dataset.appointmentId;

        const requestData = {
            new_date: newDate,
            new_start_time: startTime,
            new_end_time: endTime,
            appointment_id: appointmentId,
        };

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');

        fetch(`/reschedule-appointment/${appointmentId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify(requestData),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    document
                        .getElementById("reschedule-modal")
                        .classList.add("hidden");
                    updateEvents(newDate);

                    console.log(data);
                } else {
                    alert(data.message || "Error occurred.");
                    console.log(data);
                }
            })
            .catch((error) => {
                console.error("Error rescheduling appointment:", error);

                
               
            });
    });

}

document.addEventListener("DOMContentLoaded", function () {
    const openModalButton = document.getElementById("openModalButton"); // Button to open the modal
    const closeModalButton = document.querySelector("#reschedule-modal .close"); // Close button
    const rescheduleModal = document.getElementById("reschedule-modal"); // Modal element

    // Show the modal when the button is clicked
    openModalButton.addEventListener("click", function () {
        rescheduleModal.style.display = "flex"; // Show the modal
    });

    // Hide the modal when the close button is clicked
    closeModalButton.addEventListener("click", function () {
        rescheduleModal.style.display = "none"; // Hide the modal
    });

    // Optional: Close the modal if you click outside the modal content
    window.addEventListener("click", function (event) {
        if (event.target === rescheduleModal) {
            rescheduleModal.style.display = "none"; // Close if clicked outside
        }
    });
});


function getActiveDay(date) {
    // Ensure date is a number
    date = parseInt(date, 10);
    
    // Validate year, month, and date
    if (isNaN(date) || isNaN(year) || isNaN(month)) {
        console.error("Invalid date, year, or month:", { date, year, month });
        return;
    }

    const day = new Date(year, month, date);
    
    // Check if the constructed date is valid
    if (isNaN(day.getTime())) {
        console.error("Invalid Date object:", day);
        return;
    }
    
    const dayName = day.toString().split(" ")[0];
    eventDay.innerHTML = dayName;
    eventDate.innerHTML = `${date} ${months[month]} ${year}`;

    // Format the date to YYYY-MM-DD format for the API call
    const formattedDate = `${year}-${(month + 1).toString().padStart(2, '0')}-${date.toString().padStart(2, '0')}`;

    console.log("Formatted Date:", formattedDate); // Debugging line

    // Call updateEvents with the formatted date
    updateEvents(formattedDate);
}





// Initialize the calendar
initCalendar();




