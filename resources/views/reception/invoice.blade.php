@extends('reception.layout')
@section('title', 'Invoices')
@extends('reception.header')

@section('content')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }
    .container {
        padding: 20px;
    }
</style>

<div class="container">
    <h2 class="text-center">Invoices for {{ now()->format('d M, Y') }}</h2>

    @if($invoices->isEmpty())
        <p>No invoices found for today.</p>
    @else
    <table>
    <thead>
        <tr>
            <th>#</th>
            <th>Patient Name</th>
            <th>Total Amount</th>
            <th>Invoice Date</th>
            <th>Payment Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $index => $invoice)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $invoice->patient_name }}</td>
                <td>KES {{ number_format($invoice->total_amount, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</td>
                <td>
                    @if ($invoice->invoice_status)
                    <span style="color: green; font-weight: bold;">Paid</span>
                    @else
                    <span style="color: red; font-weight: bold;">Unpaid</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('invoice.content', ['invoiceId' => $invoice->id]) }}" class="btn btn-primary">
                        View
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    @endif
</div>
@endsection
