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
        padding: 8px 15px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }
    .pay-button:hover {
        background-color: #218838;
    }
    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Modal Box */
    .modal-content {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        width: 350px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation: slideIn 0.3s ease-in-out;
    }

    /* M-Pesa Logo */
    .mpesa-logo {
        width: 150px;
        display: block;
        margin: 0 auto 10px;
    }

    /* Input Field */
    .modal input {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border: 2px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        text-align: center;
    }

    /* Payment & Cancel Buttons */
    .modal button {
        width: 100%;
        padding: 12px;
        border: none;
        margin: 5px 0;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }

    .modal .pay {
        background-color: #28a745;
        color: white;
        font-weight: bold;
        transition: 0.3s;
    }

    .modal .pay:hover {
        background-color: #218838;
    }

    .modal .cancel {
        background-color: #dc3545;
        color: white;
        font-weight: bold;
        transition: 0.3s;
    }

    .modal .cancel:hover {
        background-color: #c82333;
    }

    /* Fade In Animation */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Slide In Animation */
    @keyframes slideIn {
        from { transform: translateY(-30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
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
                            <button class="pay-button" onclick="openPaymentModal({{ $invoice->id }}, '{{ $invoice->total_amount }}')">
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
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <img src=" {{ asset ('images/Mpesa.png')}}" 
             alt="M-Pesa Logo" class="mpesa-logo">
        <h4>Enter Phone Number</h4>
        <input type="text" id="phone" placeholder="e.g. 2547XXXXXXXX">
        <button class="pay" onclick="payInvoice()">Pay Now</button>
        <button class="cancel" onclick="closePaymentModal()">Cancel</button>
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    let currentInvoiceId = null;
    let currentTotalAmount = null;

    // Open payment modal
    function openPaymentModal(invoiceId, totalAmount) {
        currentInvoiceId = invoiceId;
        currentTotalAmount = totalAmount;
        document.getElementById('paymentModal').style.display = 'flex';
    }

    // Close modal
    function closePaymentModal() {
        document.getElementById('paymentModal').style.display = 'none';
        document.getElementById('phone').value = "";
    }

    // Process Payment
    async function payInvoice() {
        const phone = document.getElementById('phone').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (!phone.match(/^254(1|7)[0-9]{8}$/)) {
    alert("Please enter a valid phone number starting with 2541 or 2547 (e.g., 254112054231 or 2547XXXXXXXX)");
    return;
}

        try {
            let response = await fetch("{{ route('mpesa.stkpush') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    invoice_id: currentInvoiceId,
                    phone: phone
                }),
            });

            let data = await response.json();

            if (response.ok) {
                alert("Payment initiated. Please check your phone.");
                closePaymentModal();
            } else {
                alert(data.error || "Payment initiation failed. Try again.");
            }

        } catch (error) {
            alert("Error processing payment. Try again.");
        }
    }
</script>

@endsection
