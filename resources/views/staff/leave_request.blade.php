<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Leave Request</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/leave_request.css') }}">

</head>
<body>

<div class="container mt-5" id = "leave form" style = "width :900px !important; padding :15px !important; margin-left:20px !important">
    

    <div id="successMessage" class="alert alert-success d-none">
        Leave request submitted successfully!
    </div>

    <form id="leaveRequestForm" action="{{ route('leave.store') }}" method="POST">
    
    @csrf

    <div class="mb-3">
    <h2 style= "color:black !important ; display:visible !important" >Staff Leave Request</h2>
    </div>
        <!-- Staff Information -->
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" id="email" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" class="form-control" id="telephone" disabled>
        </div>

        <!-- Leave Type Dropdown -->
        <div class="mb-3">
    <label class="form-label">Leave Type</label>
    <select class="form-control" id="leaveType" name="leave_type_id" required>
        <option value="">-- Select Leave Type --</option>
        @foreach($leaveTypes as $leaveType)
            <option value="{{ $leaveType->id }}">{{ $leaveType->name }}</option>
        @endforeach
    </select>
</div>


        <!-- Start Date -->
        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" class="form-control" name="start_date" required>
        </div>

        <!-- End Date -->
        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" class="form-control" name="end_date" required>
        </div>

        <!-- Reason -->
        <div class="mb-3">
            <label class="form-label">Reason for Leave</label>
            <textarea class="form-control" name="reason" rows="3" required></textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
</div>
<script src="{{asset('js/leave.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>