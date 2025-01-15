<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapist Appointments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Therapist Appointments</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Child ID</th>
                    <th>Doctor ID</th>
                    <th>Staff Name</th>
                    <th>Specialization</th>
                    <th>Appointment Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->child_id }}</td>
                        <td>{{ $appointment->doctor_id }}</td>
                        <td>{{ $appointment->staff_name }}</td>
                        <td>{{ $appointment->specialization }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->start_time }}</td>
                        <td>{{ $appointment->end_time }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No appointments found for therapists.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
