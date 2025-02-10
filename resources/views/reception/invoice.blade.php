@extends('reception.layout')

@section('title', 'Invoices')
@extends('reception.header')

@section('content')

<style>
    .notification {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .notification .badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: bold;
        display: none; /* Hidden by default */
    }

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
    tr[data-has-copayment="true"] {
    background-color:rgb(202, 238, 255); /* Light yellow background for rows with copayments */
}
</style>

<div class="container">

    <!-- Notification Bell -->
    <div class="notification" onclick="viewCopayments()">
        <span class="badge" id="copayment-notification">0</span>
        <img src="{{ asset('images/Notifications.png') }}" alt="Notification Bell" width="40">
    </div>

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
                <th>Payment Method</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($invoices as $index => $invoice)
            @php
                $invoiceDetails = json_decode($invoice->invoice_details, true);
                $hasCopayment = false;
                foreach ($invoiceDetails as $service) {
                    if (!empty($service['copay_amount'])) {
                        $hasCopayment = true;
                        break;
                    }
                }
            @endphp
            <tr data-invoice-id="{{ $invoice->id }}" data-has-copayment="{{ $hasCopayment ? 'true' : 'false' }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $invoice->patient_name }}</td>
                <td>KES {{ number_format($invoice->total_amount, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</td>
                <td class="status">
                    @if ($invoice->invoice_status)
                        <span style="color: green; font-weight: bold;">Paid</span>
                    @else
                        <span style="color: red; font-weight: bold;">Unpaid</span>
                    @endif
                </td>
                <td>
                    {{ $invoice->payment_method ?? 'N/A' }}
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
        <input type="text" id="phone" placeholder="e.g. 07XXXXXXXX">
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

    if (!/^(07|01)\d{8}$/.test(phone)) {
        alert("Please enter a valid phone number starting with 07 or 01 (e.g., 0712345678 or 0112345678)");
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
            waitForPaymentConfirmation(currentInvoiceId); // Start polling for confirmation
        } else {
            alert(data.error || "Payment initiation failed. Try again.");
        }

    } catch (error) {
        alert("Error processing payment. Try again.");
    }
}

// Poll server to check payment status
function waitForPaymentConfirmation(invoiceId) {
    let attempt = 1; // Track the number of checks

    const checkStatus = async () => {
        console.log(`Check #${attempt}: Checking payment status for invoice ID ${invoiceId}...`);

        try {
            let response = await fetch(`/check-payment-status/${invoiceId}`);
            let data = await response.json();

            console.log(`Check #${attempt}: Response received -`, data);

            if (data.paid) { // If invoice_status is true
                console.log(`Check #${attempt}: Payment successful!`);

                // Show success popup
                showPopup("Payment Successful", "Your payment has been received!");

                // Update UI: Change "Unpaid" to "Paid"
                let row = document.querySelector(`tr[data-invoice-id="${invoiceId}"]`);
                if (row) {
                    let statusCell = row.querySelector(".status");
                    statusCell.innerHTML = `<span style="color: green; font-weight: bold;">Paid</span>`;

                    // Remove the "Pay Now" button
                    let payButton = row.querySelector(".pay-button");
                    if (payButton) {
                        payButton.remove();
                    }
                }

                return; // Stop polling
            }

            console.log(`Check #${attempt}: Payment not received yet, retrying in 5 seconds...`);
            attempt++; // Increment attempt count

            // Retry after 5 seconds if payment is still pending
            setTimeout(checkStatus, 5000);
        } catch (error) {
            console.error(`Check #${attempt}: Error checking payment status:`, error);
            console.log(`Check #${attempt}: Retrying in 5 seconds...`);
            setTimeout(checkStatus, 5000);
        }
    };

    checkStatus();
}



// Show popup

function showPopup(title, message) {
    // Create the popup container
    let popup = document.createElement("div");
    popup.style.position = "fixed";
    popup.style.top = "50%";
    popup.style.left = "50%";
    popup.style.transform = "translate(-50%, -50%)";
    popup.style.backgroundColor = "#fff";
    popup.style.padding = "30px";
    popup.style.borderRadius = "12px";
    popup.style.boxShadow = "0px 8px 16px rgba(0, 0, 0, 0.2)";
    popup.style.textAlign = "center";
    popup.style.zIndex = "1000";
    popup.style.maxWidth = "400px";
    popup.style.width = "90%";
    popup.style.animation = "fadeIn 0.3s ease-in-out";

    // Add the animated tick icon
    popup.innerHTML = `
        <div class="tick-container" style="margin-bottom: 20px;">
            <svg width="80" height="80" viewBox="0 0 80 80">
                <circle cx="40" cy="40" r="38" stroke="#4CAF50" stroke-width="4" fill="none"
                    stroke-dasharray="240" stroke-dashoffset="240" class="animated-circle"></circle>
                <path d="M20 40 L35 55 L60 25" stroke="#4CAF50" stroke-width="4" fill="none"
                    stroke-dasharray="60" stroke-dashoffset="60" class="animated-tick"></path>
            </svg>
        </div>
        <h3 style="margin: 0; font-size: 24px; color: #333;">${title}</h3>
        <p style="margin: 10px 0 20px; font-size: 16px; color: #666;">${message}</p>
        <button onclick="this.parentElement.remove()" style="background-color: #4CAF50; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px;">Close</button>
    `;

    // Append the popup to the body
    document.body.appendChild(popup);

    // Start animations after the element is added to the DOM
    setTimeout(() => {
        document.querySelector(".animated-circle").style.animation = "drawCircle 0.6s ease-in-out forwards 0.3s";
        document.querySelector(".animated-tick").style.animation = "drawTick 0.4s ease-in-out forwards 0.9s";
    }, 50);
}

// Add CSS animations for the tick icon
const style = document.createElement("style");
style.innerHTML = `
    @keyframes drawCircle {
        from {
            stroke-dashoffset: 240;
        }
        to {
            stroke-dashoffset: 0;
        }
    }
    @keyframes drawTick {
        from {
            stroke-dashoffset: 60;
        }
        to {
            stroke-dashoffset: 0;
        }
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translate(-50%, -55%);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }
`;
document.head.appendChild(style);

document.addEventListener("DOMContentLoaded", function () {
    checkCopayments();
});

// Function to check for copayments in the invoices
function checkCopayments() {
    let copayCount = 0;

    document.querySelectorAll("tr[data-has-copayment='true']").forEach(row => {
        copayCount++;
    });

    let notificationBadge = document.getElementById("copayment-notification");
    if (copayCount > 0) {
        notificationBadge.textContent = copayCount;
        notificationBadge.style.display = "block";
    }
}

// Function to show copayment details when clicking on the notification
function viewCopayments() {
    alert("Some invoices require co-payments. Please check the list.");
}



</script>

@endsection
