@extends('reception.layout')
@section('title', 'Invoice Details')

@section('content')
<style>
    /* Hide buttons when printing */
    @media print {
        button, a {
            display: none !important;
        }
    }
</style>

<div class="container">
    <h2>Invoice Details</h2>
    <p><strong>Patient Name:</strong> {{ $child->full_name }}</p>
    <p><strong>Registration Number:</strong> {{ $child->registration_number }}</p>
    <p><strong>Gender:</strong> {{ $gender }}</p>
    <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($child->dob)->format('d M, Y') }}</p>

    <h3>Services</h3>
    <ul>
        @foreach ($invoice->invoice_details as $service => $price)
            <li>{{ $service }}: KES {{ number_format($price, 2) }}</li>
        @endforeach
    </ul>

    <p><strong>Total Amount:</strong> KES {{ number_format($invoice->total_amount, 2) }}</p>

    <button onclick="window.print()" class="btn btn-success">Print</button>
    <a href="{{ route('invoices') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
