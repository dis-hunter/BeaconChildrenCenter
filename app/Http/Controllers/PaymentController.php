<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getPaymentMethods()
    {
        // Fetch payment_mode_id from payments table
        $payments = Payment::select('payment_mode_id')->get();

        return response()->json($payments);
    }
}
