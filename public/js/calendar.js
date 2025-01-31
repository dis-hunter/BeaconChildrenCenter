class Calendar {
    constructor() {
        this.initializeElements();
        this.initializeState();
        this.initializeEventListeners();
        this.render();
        this.initElements();
        this.bindEvents();
        this.initializeModals();
    }

    initializeElements() {
        this.elements = {
            calendar: document.querySelector(".calendar"),
            date: document.querySelector(".date"),
            daysContainer: document.querySelector(".days"),
            prev: document.querySelector(".prev"),
            next: document.querySelector(".next"),
            todayBtn: document.querySelector(".today-btn"),
            gotoBtn: document.querySelector(".goto-btn"),
            dateInput: document.querySelector(".date-input"),
            eventDay: document.querySelector(".event-day"),
            eventDate: document.querySelector(".event-date"),
            eventsContainer: document.querySelector(".events")
        };
    }

    initElements() {
        this.addEventBtn = document.querySelector(".add-event");
        this.addEventContainer = document.querySelector(".add-event-wrapper");
        this.addEventCloseBtn = document.querySelector(".close");
        this.addEventTitle = document.querySelector(".event_name");
        this.addEventFrom = document.querySelector(".event_time_from");
        this.addEventTo = document.querySelector(".event_time_end");
        this.addEventsSubmit = document.querySelector(".add-event-btn");
        this.serviceDropdown = document.getElementById("service");
        this.specialistContainer = document.getElementById("specialist-container");
        this.specialistDropdown = document.getElementById("specialist");
        this.bookAppointmentBtn = document.getElementById("book-appointment");
    }

    bindEvents() {
        if (this.addEventBtn && this.addEventContainer && this.addEventCloseBtn) {
            this.addEventBtn.addEventListener("click", () => this.toggleAddEventForm());
            this.addEventCloseBtn.addEventListener("click", () => this.closeAddEventForm());
        }

        if (this.serviceDropdown && this.specialistDropdown && this.specialistContainer) {
            this.serviceDropdown.addEventListener("change", () => this.loadSpecialists());
            this.specialistDropdown?.addEventListener("change", () => this.checkDoctorAvailability());
        }

        if (this.addEventsSubmit) {
            this.addEventsSubmit.addEventListener("click", (event) => this.submitAppointment(event));
        }

        $(document).ready(() => {
            $('#doctor_specialization').change(() => this.loadDoctorsBySpecialization());
        });
    }


    initializeState() {
        this.today = new Date();
        this.today.setHours(0,0,0,0);//Normalize
        this.activeDay = null;
        this.month = this.today.getMonth();
        this.year = this.today.getFullYear();
        this.selectedDate=null;
        this.months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
    }

    initializeModals() {
        // const openModalButton = document.getElementById("openModalButton");
        // const closeModalButton = document.querySelector("#reschedule-modal .close");

        this.rescheduleModal = document.getElementById("reschedule-modal");
        document.getElementById("close-modal").addEventListener("click", () => {
            this.rescheduleModal.classList.add("hidden");
        })

        window.addEventListener("click", (event) => {
            if (event.target === this.rescheduleModal) {
                this.rescheduleModal.classList.add("hidden");
            }
        });


        // if (openModalButton) {
        //     openModalButton.addEventListener("click", () => {
        //         rescheduleModal.style.display = "flex";
        //     });
        // }

        // if (closeModalButton) {
        //     closeModalButton.addEventListener("click", () => {
        //         rescheduleModal.style.display = "none";
        //     });
        // }
    }

    initializeEventListeners() {
        this.elements.prev.addEventListener("click", () => this.prevMonth());
        this.elements.next.addEventListener("click", () => this.nextMonth());
        this.elements.todayBtn.addEventListener("click", () => this.goToToday());
        this.elements.gotoBtn.addEventListener("click", () => this.gotoDate());
        this.elements.dateInput.addEventListener("input", (e) => this.handleDateInput(e));

        document.addEventListener("appointmentModified", () => this.refreshEvents());
    }

    render() {
        const { firstDay, lastDay, prevLastDay } = this.getMonthDetails();
        const days = this.generateCalendarDays(firstDay, lastDay, prevLastDay);
        this.elements.date.innerHTML = `${this.months[this.month]} ${this.year}`;
        this.elements.daysContainer.innerHTML = days;
        this.addDayClickListeners();
    }

    getMonthDetails() {
        const firstDay = new Date(this.year, this.month, 1);
        const lastDay = new Date(this.year, this.month + 1, 0);
        const prevLastDay = new Date(this.year, this.month, 0);
        return { firstDay, lastDay, prevLastDay };
    }

    generateCalendarDays(firstDay, lastDay, prevLastDay) {
        const firstDayIndex = firstDay.getDay();
        const lastDate = lastDay.getDate();
        const prevDays = prevLastDay.getDate();
        const lastDayIndex = lastDay.getDay();
        const nextDays = 7 - lastDayIndex - 1;

        let days = this.getPrevMonthDays(firstDayIndex, prevDays);
        days += this.getCurrentMonthDays(lastDate);
        days += this.getNextMonthDays(nextDays);

        return days;
    }

    getPrevMonthDays(firstDayIndex, prevDays) {
        let days = "";
        for (let x = firstDayIndex; x > 0; x--) {
            days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
        }
        return days;
    }

    isValidFutureDate(selectedDate){
        const today = new Date();
        today.setHours(0,0,0,0);
        return selectedDate >= today;
    }

    getCurrentMonthDays(lastDate) {
        let days = "";
        for (let i = 1; i <= lastDate; i++) {
            const isToday = this.isToday(i);
            const hasEvent = this.hasEvent(i);
            days += this.createDayElement(i, isToday, hasEvent);
        }
        return days;
    }

    getNextMonthDays(nextDays) {
        let days = "";
        for (let j = 1; j <= nextDays; j++) {
            days += `<div class="day next-date">${j}</div>`;
        }
        return days;
    }

    isToday(day) {
        return (
            day === this.today.getDate() &&
            this.month === this.today.getMonth() &&
            this.year === this.today.getFullYear()
        );
    }

    hasEvent(day) {
        // Implement your event checking logic here
        return false;
    }

    createDayElement(day, isToday, hasEvent) {
        const classes = ["day"];
        if (isToday) {
            classes.push("today", "active");
            this.activeDay = day;
            this.getActiveDay(day);
        }
        if (hasEvent) classes.push("event");
        return `<div class="${classes.join(" ")}">${day}</div>`;
    }

    prevMonth() {
        this.month--;
        if (this.month < 0) {
            this.month = 11;
            this.year--;
        }
        this.render();
    }

    nextMonth() {
        this.month++;
        if (this.month > 11) {
            this.month = 0;
            this.year++;
        }
        this.render();
    }

    goToToday() {
        this.month = this.today.getMonth();
        this.year = this.today.getFullYear();
        this.render();
    }

    handleDateInput(e) {
        const input = e.target;
        input.value = input.value.replace(/[^0-9/]/g, "");
        if (input.value.length === 2) input.value += "/";
        if (input.value.length > 7) input.value = input.value.slice(0, 7);
    }

    gotoDate() {
        const dateArr = this.elements.dateInput.value.split("/");
        if (dateArr.length === 2) {
            if (dateArr[0] > 0 && dateArr[0] < 13 && dateArr[1].length === 4) {
                this.month = dateArr[0] - 1;
                this.year = parseInt(dateArr[1]);
                this.render();
                return;
            }
        }
        alert("Invalid Date");
    }

    getActiveDay(date) {
        const formattedDate = this.formatDate(date);
        const day = new Date(this.year, this.month, date);
        const dayName = day.toString().split(" ")[0];

        this.elements.eventDay.innerHTML = dayName;
        this.elements.eventDate.innerHTML = `${date} ${this.months[this.month]} ${this.year}`;
        this.updateEvents(formattedDate);
    }

    getFormattedDate() {
        if(!this.selectedDate){
            return null;
        }
        const date = new Date(this.selectedDate);
        const year = date.getFullYear();
        const month = String(date.getMonth()+1).padStart(2,'0');
        const day = String(date.getDate()).padStart(2,'0');
        return `${year}-${month}-${day}`;
    }

    formatDate(date) {
        return `${this.year}-${(this.month + 1).toString().padStart(2, '0')}-${date.toString().padStart(2, '0')}`;
    }

    refreshEvents() {
        const formattedDate = this.formatDate(this.activeDay);
        this.updateEvents(formattedDate);
    }

    // Toggle Add Event Form visibility
    toggleAddEventForm() {
        this.addEventContainer.classList.toggle("active");
    }

    // Close Add Event Form
    closeAddEventForm() {
        this.addEventContainer.classList.remove("active");
    }

    addDayClickListeners() {
        const days = document.querySelectorAll(".day");
        days.forEach((day) => {
            day.addEventListener("click", (e) => this.handleDayClick(e));
        });
    }

    handleDayClick(e) {
        const days = document.querySelectorAll(".day");
        days.forEach(day => day.classList.remove("active"));

        const clickedDay = e.target;
        const dayNumber = Number(clickedDay.innerHTML);

        const selectedDate = new Date(this.year,this.month, dayNumber);

        // Handle month transitions
        if (clickedDay.classList.contains("prev-date")) {
            this.prevMonth();
            this.activeDay = dayNumber;
            this.selectedDate= new Date(this.year,this.month - 1, dayNumber);
        } else if (clickedDay.classList.contains("next-date")) {
            this.nextMonth();
            this.activeDay = dayNumber;
            this.selectedDate= new Date(this.year,this.month + 1, dayNumber);
        } else {
            this.activeDay = dayNumber;
            this.selectedDate= new Date(this.year,this.month,dayNumber);
            clickedDay.classList.add("active");
        }

        // Clear existing appointments
        const eventsContainer = document.getElementById("events-container");
        if (eventsContainer) {
            eventsContainer.innerHTML = `
                <div class="loader ml-3"></div>
            <style>
                .loader {
                    height: 5px;
                    width: inherit;
                    --c:no-repeat linear-gradient(#6100ee 0 0);
                    background: var(--c),var(--c),#d7b8fc;
                    background-size: 60% 100%;
                    animation: l16 3s infinite;
                    border-radius: 5px;
                    }
                @keyframes l16 {
                    0%   {background-position:-150% 0,-150% 0}
                    66%  {background-position: 250% 0,-150% 0}
                    100% {background-position: 250% 0, 250% 0}
                    }
            </style>
            `;
        }

        // Update active day display and fetch appointments
        this.getActiveDay(this.activeDay);
    }

    async updateEvents(date) {
        const container = document.getElementById("events-container");

        try {
            // Show loading state
            container.innerHTML = `
                <div class="loader ml-3"></div>
            <style>
                .loader {
                    height: 5px;
                    width: inherit;
                    --c:no-repeat linear-gradient(#6100ee 0 0);
                    background: var(--c),var(--c),#d7b8fc;
                    background-size: 60% 100%;
                    animation: l16 3s infinite;
                    border-radius: 5px;
                    }
                @keyframes l16 {
                    0%   {background-position:-150% 0,-150% 0}
                    66%  {background-position: 250% 0,-150% 0}
                    100% {background-position: 250% 0, 250% 0}
                    }
            </style>
            `;

            const response = await fetch(`/get-appointments?date=${date}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const appointments = await response.json();

            // Clear existing appointments before rendering new ones
            container.innerHTML = "";

            this.renderEvents(appointments);

        } catch (error) {
            console.error("Error fetching appointments:", error);
            container.innerHTML = `
                <div class="error-message">
                    <p>Error loading appointments. Please try again.</p>
                </div>
            `;
        }
    }

    renderEvents(appointments) {
        const container = document.getElementById("events-container");
        container.innerHTML = ""; // Clear existing content
        container.style.display = "block";

        if (!appointments || appointments.length === 0) {
            container.innerHTML = `
                <div class="no-event ml-4">
                    <h3>No Appointments for ${this.activeDay} ${this.months[this.month]} ${this.year}</h3>
                </div>`;
            return;
        }

        // Sort appointments by start time
        appointments.sort((a, b) => {
            return a.start_time.localeCompare(b.start_time);
        });

        appointments.forEach(appointment => {
            const eventElement = this.createEventElement(appointment);
            container.appendChild(eventElement);
            this.addEventListeners(eventElement, appointment);
        });
    }


    createEventElement(appointment) {
        const eventDiv = document.createElement("div");
        eventDiv.classList.add("event");

        const { formattedParentName, formattedChildName, formattedStaffName } = this.formatNames(appointment);

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
                <p><strong>Child name:</strong>${formattedChildName}</p>
                <p><strong>Parent:</strong> ${formattedParentName}</p>
                <p><strong>Phone:</strong> ${appointment.parent_phone}</p>
                <p><strong>Email:</strong> ${appointment.parent_email}</p>
            </div>
            ${this.createActionButtons(appointment)}
        `;

        return eventDiv;
    }

    // loadSpecialists() {
    //     const selectedService = this.serviceDropdown.value;
    //     this.specialistDropdown.innerHTML = '<option value="">-- Select Specialist --</option>';

    //     if (selectedService) {
    //         fetch(`/api/specialists?service=${selectedService}`)
    //             .then((response) => response.json())
    //             .then((data) => {
    //                 if (data.length > 0) {
    //                     this.specialistContainer.style.display = "block";
    //                     data.forEach((specialist) => {
    //                         const option = document.createElement("option");
    //                         option.value = specialist.id;
    //                         option.textContent = specialist.name;
    //                         this.specialistDropdown.appendChild(option);
    //                     });
    //                 } else {
    //                     this.specialistContainer.style.display = "none";
    //                     alert("No specialists found for the selected service.");
    //                 }
    //             })
    //             .catch((error) => {
    //                 console.error("Error fetching specialists:", error);
    //                 alert("An error occurred while fetching specialists.");
    //             });
    //     } else {
    //         this.specialistContainer.style.display = "none";
    //     }
    // }

    async checkTimeAvailability(doctor_id, date, startTime, endTime){
        try {
            const response = await fetch(
                `/check-availability?doctor_id=${doctor_id}&date=${date}&start_time=${startTime}&end_time=${endTime}`
            );
            const data = await response.json();
            return data.available;
        } catch (error) {
            console.error("Availability check failed: ", error);
            return false;            
        }
    }

    // checkDoctorAvailability() {
    //     const doctorId = this.specialistDropdown?.value;
    //     const datePicker = document.getElementById("event_date");
    //     const timeStart = document.getElementById("event_time_from")?.value;
    //     const timeEnd = document.getElementById("event_time_end")?.value;

    //     if (doctorId && datePicker?.value && timeStart && timeEnd) {
    //         fetch(`/check-availability?doctor_id=${doctorId}&date=${datePicker.value}&start_time=${timeStart}&end_time=${timeEnd}`)
    //             .then((response) => response.json())
    //             .then((data) => {
    //                 if (!data.available) {
    //                     alert("Doctor is unavailable during this time. Please select a different time.");
    //                 }
    //             })
    //             .catch((error) => {
    //                 console.error("Error checking doctor availability:", error);
    //             });
    //     } else {
    //         console.warn("Missing required fields for availability check.");
    //     }
    // }

    loadDoctorsBySpecialization() {
        console.log("loadDoctorsBySpecialization");
        const specializationId = $('#doctor_specialization').val();
        const specialistSelect = $('#specialist');
        const specialistContainer = $('#specialist-container');
        const noSpecialistsMessage = $('#no-specialists-message');

        specialistSelect.empty();
        specialistContainer.append('')
        specialistSelect.append('<option value="">-- Select Specialist --</option>');
        specialistContainer.hide();
        noSpecialistsMessage.hide();

        if (specializationId) {
            specialistContainer.show();

            $.ajax({
                url: `/get-doctors/${specializationId}`,
                type: 'GET',
                dataType: 'json',
                success: (data) => {
                    if (data.message) {
                        noSpecialistsMessage.text(data.message).show();
                    } else if (data.length > 0) {
                        data.forEach((doctor) => {
                            specialistSelect.append(`<option value="${doctor.id}">${doctor.full_name}</option>`);
                        });
                        noSpecialistsMessage.hide();
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Error fetching doctors:', error);
                    alert('An error occurred while fetching doctors.');
                },
            });
        }
    }

    formatNames(appointment) {
        try {
            const parentName = JSON.parse(appointment.parent_name);
            const childName = JSON.parse(appointment.child_name);
            const staffName = JSON.parse(appointment.staff_name);

            return {
                formattedParentName: `${parentName.first_name} ${parentName.middle_name} ${parentName.last_name}`,
                formattedChildName: `${childName.first_name} ${childName.middle_name} ${childName.last_name}`,
                formattedStaffName: `${staffName.first_name} ${staffName.middle_name} ${staffName.last_name}`
            };
        } catch (error) {
            console.error("Error parsing names:", error);
            return {
                formattedParentName: "N/A",
                formattedChildName: "N/A",
                formattedStaffName: "N/A"
            };
        }
    }

    createActionButtons(appointment) {
        return `
            <button class="cancel-btn" data-id="${appointment.appointmentId}">Cancel</button>
            <button class="reschedule-btn" 
                data-id="${appointment.appointmentId}" 
                data-title="${appointment.appointment_title}" 
                data-start-time="${appointment.start_time}" 
                data-end-time="${appointment.end_time}" 
                data-appointment-date="${appointment.appointment_date}">Reschedule</button>
        `;
    }

    addEventListeners(eventElement, appointment) {
        const cancelBtn = eventElement.querySelector(".cancel-btn");
        const rescheduleBtn = eventElement.querySelector(".reschedule-btn");

        cancelBtn.addEventListener("click", () => this.handleCancelAppointment(appointment.appointmentId));
        rescheduleBtn.addEventListener("click", () => this.handleRescheduleClick(rescheduleBtn));
    }

    async handleCancelAppointment(appointmentId) {
        if (!confirm("Are you sure you want to cancel this appointment?")) return;

        try {
            const response = await fetch(`/cancel-appointment/${appointmentId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json",
                }
            });

            if (response.ok) {
                alert("Appointment canceled successfully.");
                this.onAppointmentActionSuccess();
            } else {
                throw new Error("Failed to cancel appointment.");
            }
        } catch (error) {
            console.error("Error canceling appointment:", error);
            alert("An error occurred while canceling the appointment.");
        }
    }

    handleRescheduleClick(button) {
        const modal = document.getElementById("reschedule-modal");
        const form = document.getElementById("reschedule-form");

        this.populateRescheduleForm(button, form);
        modal.classList.remove("hidden");

        document.getElementById("close-modal").addEventListener("click", () => {
            modal.classList.add("hidden");
        });
    }


    populateRescheduleForm(button, form) {
        const appointmentData = button.dataset;
        form.dataset.appointmentId = appointmentData.id;

        document.getElementById("appointment-title").value = appointmentData.title;
        document.getElementById("appointment-start-time").value = appointmentData.startTime;
        document.getElementById("appointment-end-time").value = appointmentData.endTime;
        document.getElementById("newDate").value = appointmentData.appointmentDate;
        document.getElementById("hidden-start-time").value = appointmentData.startTime;
        document.getElementById("hidden-end-time").value = appointmentData.endTime;

        // Add the reschedule form submission handler
        form.removeEventListener("submit", this.handleRescheduleSubmit);
        form.addEventListener("submit", this.handleRescheduleSubmit.bind(this));
    }

    async handleRescheduleSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const appointmentId = form.dataset.appointmentId;

        const requestData = {
            new_date: form.querySelector("#newDate").value,
            new_start_time: form.querySelector("#appointment-start-time").value,
            new_end_time: form.querySelector("#appointment-end-time").value,
            appointment_id: appointmentId,
        };

        const newDate = new Date(requestData.new_date);
        if(!this.isValidFutureDate(newDate)){
            alert("Cannot Reschedule to a past date!");
            return;
        }

        const isAvailable = await checkTimeAvailability(
            form.doctor_id.value,
            requestData.new_date,
            requestData.new_start_time,
            requestData.new_end_time
        );

        if(!isAvailable){
            alert("Selected Time slot is not available");
            return;
        }

        try {
            const response = await fetch(`/reschedule-appointment/${appointmentId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(requestData)
            });

            const result = await response.json();

            if (result.success) {
                this.rescheduleModal.classList.add("hidden");
                this.onAppointmentActionSuccess();
                alert("Appointment rescheduled successfully");
            } else {
                throw new Error(result.message || "Failed to reschedule appointment.");
            }
        } catch (error) {
            console.error("Error rescheduling appointment:", error);
            alert(`Error: ${error.message}`);
        }
    }

    async submitAppointment(event) {
        event.preventDefault();

        if(!this.selectedDate || !this.isValidFutureDate(this.selectedDate)){
            alert('Please select a valid future date');
            return;
        }

        const selectedChildCheckbox = document.querySelector('input[type="checkbox"]:checked[id^="child_id_"]');
        const selectedChildId = selectedChildCheckbox?.value || "";

        const formattedDate = this.getFormattedDate();
        if(!formattedDate){
            alert("Please select a date for the appointment");
            return;
        }


        const request = {
            appointment_title: this.addEventTitle?.value || "",
            start_time: this.addEventFrom?.value || "",
            end_time: this.addEventTo?.value || "",
            child_id: selectedChildId,
            appointment_date: this.getFormattedDate(),
            doctor_id: this.specialistDropdown?.value || null,
            status: "pending",
        };

        if(request.start_time >= request.end_time){
            alert('End time must be after start time!');
            return;
        }

        const isAvailable = await this.checkTimeAvailability(
            request.doctor_id,
            request.appointment_date,
            request.start_time,
            request.end_time
        );

        if(!isAvailable){
            alert('Slected time slot is not avalaible!');
        }
        try {
            const response = await fetch("/appointments", {
                method:"POST",
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(request),
                });
            const result = await response.json();

            if(result.success){
                this.closeAddEventForm();
                this.onAppointmentActionSuccess();
                alert("Appointment created successfully!");
            }else{
                throw new Error(result.message || "Failed to create Appointment");
            }
        } catch (error) {
            console.error("Appointment creation error: ",error);
            alert(`Error: ${error.message}`)
        }
    }

    onAppointmentActionSuccess() {
        const event = new Event("appointmentModified");
        document.dispatchEvent(event);
    }



}

document.addEventListener("DOMContentLoaded", () => {
    const calendar = new Calendar();
    document.addEventListener("click", (e) =>{
        if(e.target.classList.contains("cancel-btn")){
            calendar.handleCancelAppointment(e.target.dataset.id);
        }
    });
});
