$('#appointment_date, #start_time, #end_time, #doctor_id, #specialization_id').on('change', function () {
    let date = $('#appointment_date').val();
    let startTime = $('#start_time').val();
    let endTime = $('#end_time').val();
    let doctorId = $('#doctor_id').val();
    let specializationId = $('#specialization_id').val();

    $.ajax({
        url: '/appointments/check-availability',
        method: 'GET',
        data: {
            date: date,
            start_time: startTime,
            end_time: endTime,
            doctor_id: doctorId,
            specialization_id: specializationId
        },
        success: function (data) {
            if (!data.isAvailable) {
                alert('This doctor is already booked at this time. Please choose another time or date.');
                $('#submit_button').attr('disabled', true);  // Disable the submit button
            } else {
                $('#submit_button').attr('disabled', false); // Enable the submit button
            }
        },
    });
});
