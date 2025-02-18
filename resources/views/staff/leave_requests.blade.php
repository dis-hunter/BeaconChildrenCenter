<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Leave Requests</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
        }

        .back-btn:hover {
            color: #0056b3;
        }
    </style>
</head>
<body style="width: 1000px !important; margin: auto;">

<div class="container mt-4">
    <!-- Back Button -->
    <a href="javascript:history.back()" class="back-btn mb-3">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <h2 class="mb-4">My Leave Requests</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Applied On</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($leaveRequests as $key => $leave)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $leave->leaveType ? $leave->leaveType->type_name : 'Unknown Type' }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                <td>{{ $leave->reason }}</td>
                <td>
                    @if($leave->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($leave->status === 'approved')
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($leave->created_at)->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No leave requests found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- FontAwesome for the arrow icon -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

</body>
</html>
