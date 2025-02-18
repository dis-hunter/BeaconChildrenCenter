
    document.addEventListener("DOMContentLoaded", function() {
        fetch("/leave-form-data")
            .then(response => response.json())
            .then(data => {
                console.log(data);

                // Populate user data
                document.getElementById("fullname").value = `${data.user.fullname.first_name ?? ''} ${data.user.fullname.middle_name ?? ''} ${data.user.fullname.last_name ?? ''}`;
                document.getElementById("email").value = data.user.email;
                document.getElementById("telephone").value = data.user.telephone;

                // Populate leave types
                const leaveTypeSelect = document.getElementById("leaveType");
                data.leaveTypes.forEach(type => {
                    const option = document.createElement("option");
                    option.value = type.id;
                    option.textContent = type.type_name;
                    leaveTypeSelect.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching data:", error));
    });
    // Handle form submission using AJAX
$(document).ready(function () {
    $("#leaveRequestForm").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: '/leave/store',
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.message) {
                    // Show a Bootstrap modal for success
                    $('body').append(`
                        <div class="modal fade" id="successModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Success</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>${response.message}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="viewRequestsBtn">View Leave Requests</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);

                    // Show the modal
                    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();

                    // Redirect to "View Leave Requests" page on button click
                    $("#viewRequestsBtn").click(function () {
                        window.location.href = "/leave/requests";
                    });

                    // Reset the form
                    $("#leaveRequestForm")[0].reset();
                }
            },
            error: function () {
                alert('An error occurred. Please try again.');
            }
        });
    });
});
