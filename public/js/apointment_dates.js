document.addEventListener('DOMContentLoaded', function () {
    const appointmentDateInput = document.getElementById('appointment_date');
    const selectedDayLabel = document.getElementById('selected_day');

    // Function to format the date into a readable format (e.g., "Monday, May 10, 2021")
    function formatDateToDay(dateString) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', options);
    }

    // Set the initial date label (when the page loads)
    const today = new Date();
    selectedDayLabel.textContent = formatDateToDay(today.toISOString());

    // Update the label when a new date is selected
    appointmentDateInput.addEventListener('input', function () {
        const selectedDate = appointmentDateInput.value;
        selectedDayLabel.textContent = formatDateToDay(selectedDate);
    });

    // Optionally, set the current date as default
    appointmentDateInput.value = today.toISOString().split('T')[0];
});
