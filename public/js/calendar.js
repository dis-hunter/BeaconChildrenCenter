class Calendar {
    constructor() {
        this.initializeElements();
        this.initializeState();
        this.initializeEventListeners();
        this.initializeModalEventListeners();
        this.render();
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

    initializeState() {
        this.today = new Date();
        this.activeDay = null;
        this.month = this.today.getMonth();
        this.year = this.today.getFullYear();
        this.months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
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

    formatDate(date) {
        return `${this.year}-${(this.month + 1).toString().padStart(2, '0')}-${date.toString().padStart(2, '0')}`;
    }

    refreshEvents() {
        const formattedDate = this.formatDate(this.activeDay);
        this.updateEvents(formattedDate);
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
        
        // Handle month transitions
        if (clickedDay.classList.contains("prev-date")) {
            this.prevMonth();
            this.activeDay = dayNumber;
        } else if (clickedDay.classList.contains("next-date")) {
            this.nextMonth();
            this.activeDay = dayNumber;
        } else {
            this.activeDay = dayNumber;
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
        console.log(this.activeDay);
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
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            const response = await fetch(`/cancel-appointment/${appointmentId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json",
                }
            });

            if (response.ok) {
                alert("Appointment canceled successfully.");
                this.onAppointmentActionSuccess();
            } else {
                const data = await response.json();
                throw new Error(data.message || "Failed to cancel appointment.");
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
            new_date: document.getElementById("newDate").value,
            new_start_time: document.getElementById("appointment-start-time").value,
            new_end_time: document.getElementById("appointment-end-time").value,
            appointment_id: appointmentId,
        };

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/reschedule-appointment/${appointmentId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify(requestData)
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                document.getElementById("reschedule-modal").classList.add("hidden");
                this.onAppointmentActionSuccess();
            } else {
                alert(data.message || "Error occurred.");
            }
        } catch (error) {
            console.error("Error rescheduling appointment:", error);
            alert("An error occurred while rescheduling the appointment.");
        }
    }

    initializeModalEventListeners() {
        const openModalButton = document.getElementById("openModalButton");
        const closeModalButton = document.querySelector("#reschedule-modal .close");
        const rescheduleModal = document.getElementById("reschedule-modal");

        if (openModalButton) {
            openModalButton.addEventListener("click", () => {
                rescheduleModal.style.display = "flex";
            });
        }

        if (closeModalButton) {
            closeModalButton.addEventListener("click", () => {
                rescheduleModal.style.display = "none";
            });
        }

        // Close modal when clicking outside
        window.addEventListener("click", (event) => {
            if (event.target === rescheduleModal) {
                rescheduleModal.style.display = "none";
            }
        });
    }

    onAppointmentActionSuccess() {
        const event = new Event("appointmentModified");
        document.dispatchEvent(event);
    }

}

document.addEventListener("DOMContentLoaded", () => {
    const calendar = new Calendar();
});
