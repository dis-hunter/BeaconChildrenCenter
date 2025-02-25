@extends('reception.layout')
@section('title', 'Invoice Details')
@extends('reception.header')
@section('content')
<style>
    
    /* Invoice styling */
    .invoice-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        position: relative;
        min-height: 600px;
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .invoice-header img {
        max-width: 150px;
        height: auto;
        margin-bottom: 10px;
        margin-left: 300px;
    }

    .invoice-header h2 {
        margin: 0;
        font-size: 20px;
        color: #333;
    }

    .invoice-details p {
        margin: 5px 0;
        font-size: 14px;
        color: #555;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .invoice-table th,
    .invoice-table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .invoice-table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    .invoice-total {
        text-align: right;
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .invoice-actions {
        text-align: center;
        margin-top: 20px;
    }

    .invoice-actions .btn {
        margin: 0 5px;
    }


@media print {
   
    button, a, .search-bar, nav, .navbar, .sidebar , .input-group{
        display: none !important;
    }

    /* Remove form borders */
    .invoice-container {
        border: none !important;
        box-shadow: none !important;
    }

}


</style>


<div class="invoice-container">
    <!-- Invoice Header with Logo -->
    <div class="invoice-header">
        <img style="margin-bottom:0;" src="{{ asset('images/logo.jpg') }}" alt="Organization Logo">
        <h2 style="margin-top: 2px;">Invoice</h2>
    </div>

    <!-- Patient Details -->
    <div class="invoice-details">
        <p><strong>Patient Name:</strong> {{ $child->full_name }}</p>
        <p><strong>Registration Number:</strong> {{ $child->registration_number }}</p>
        <p><strong>Gender:</strong> {{ $gender }}</p>
        <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($child->dob)->format('d M, Y') }}</p>
        <p><strong>Invoice Date:</strong> {{ \Carbon\Carbon::now()->format('d M, Y') }}</p>
    </div>

    <!-- Services Table -->
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Service</th>
                <th>Price (KES)</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($invoice->invoice_details as $service => $details)
    <tr>
        <td>{{ $service }}</td>
        <td>{{ number_format($details['price'], 2) }}</td>
    </tr>
@endforeach

        </tbody>
    </table>

    <!-- Total Amount -->
    <div class="invoice-total">
        <p><strong>Total Amount:</strong> KES {{ number_format($invoice->total_amount, 2) }}</p>
    </div>


    <!-- Actions -->
    <div class="invoice-actions">
        <button onclick="window.print()" class="btn btn-success">Print</button>
        <a href="{{ route('invoices') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
