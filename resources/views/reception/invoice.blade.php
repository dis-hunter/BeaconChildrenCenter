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
    .pay-button {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
    }
    .pay-button:hover {
        background-color: #218838;
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

                    @if (!$invoice->invoice_status)
                    <button class="pay-button" onclick="openPaymentModal({{ $invoice->id }}, {{ $invoice->total_amount }})">
                        Pay Now
                    </button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    @endif
</div>

<!-- Payment Modal -->
<div id="paymentModal" style="display:none;">
    <div class="modal-content">
        <label for="phone">Enter Phone Number:</label>
        <input type="text" id="phone" placeholder="e.g. 2547XXXXXXXX">
        <button onclick="payInvoice()">Pay</button>
        <button onclick="closePaymentModal()">Cancel</button>
    </div>
</div>

<script>
    // Store the invoiceId globally when opening the modal
    function openPaymentModal(invoiceId, totalAmount) {
        document.getElementById('paymentModal').style.display = 'block';
        window.currentInvoiceId = invoiceId; // Store invoiceId
        window.currentTotalAmount = totalAmount;
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').style.display = 'none';
    }

    function payInvoice() {
        const phone = document.getElementById('phone').value;

        if (!phone) {
            alert('Please enter a valid phone number.');
            return;
        }

        fetch("{{ route('mpesa.stkpush') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                invoice_id: window.currentInvoiceId, // Pass the invoice_id here
                phone: phone,
            }),
        })
        .then(response => response.json())
        .then(data => {
            alert("Payment initiated. Please check your phone.");
            closePaymentModal();
        })
        .catch(error => {
            alert("Payment initiation failed. Try again.");
            closePaymentModal();
        });
    }
</script>
@endsection
