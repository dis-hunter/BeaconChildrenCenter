
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Appointments</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Child ID</th>
                <th>Doctor ID</th>
                <th>Staff ID</th>
                <th>Appointment Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->id }}</td>
                <td>{{ $appointment->child_id }}</td>
                <td>{{ $appointment->doctor_id }}</td>
                <td>{{ $appointment->staff_id }}</td>
                <td>{{ $appointment->appointment_date }}</td>
                <td>{{ $appointment->start_time }}</td>
                <td>{{ $appointment->end_time }}</td>
                <td>{{ $appointment->status }}</td>
                <td>{{ $appointment->created_at }}</td>
                <td>{{ $appointment->updated_at }}</td>
                <td>{{ $appointment->appointment_title }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection