<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Http;
use App\Events\InvoicePaid;

class MpesaController extends Controller
{
    private $consumerKey;
    private $consumerSecret;
    private $shortCode;
    private $passkey;
    private $callbackUrl;

    public function __construct()
    {
        $this->consumerKey = env('MPESA_CONSUMER_KEY');
        $this->consumerSecret = env('MPESA_CONSUMER_SECRET');
        $this->shortCode = env('MPESA_SHORTCODE');
        $this->passkey = env('MPESA_PASSKEY');
        $this->callbackUrl = env('MPESA_CALLBACK_URL');
    }

    /**
     * Generate Mpesa Access Token
     */
    private function generateAccessToken()
    {
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

       
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)->get($url);

        if ($response->successful()) {
            $accessToken = $response->json()['access_token'] ?? null;
            
            return $accessToken;
        } else {
           
            return null;
        }
    }

    /**
     * Initiate STK Push
     */
    public function stkPush(Request $request)
{
    $request->validate([
        'invoice_id' => 'required|exists:invoices,id',
        'phone' => ['required', 'regex:/^(?:0|\+?254)(1|7)[0-9]{8}$/']
    ]);

    $invoice = Invoice::find($request->invoice_id);

    if (!$invoice || $invoice->invoice_status) {
        return response()->json(['error' => 'Invalid or already paid invoice'], 400);
    }

    $amount = (int) $invoice->total_amount;

    if ($amount <= 0) {
        return response()->json(['error' => 'Invalid amount'], 400);
    }

    // Convert phone number to 254 format
    $phone = $request->phone;
    if (preg_match('/^0(1|7)[0-9]{8}$/', $phone)) {
        $phone = '254' . substr($phone, 1);  // Remove leading 0 and prepend 254
    }

    $timestamp = now()->format('YmdHis');
    $password = base64_encode($this->shortCode . $this->passkey . $timestamp);

    $accessToken = $this->generateAccessToken();

    if (!$accessToken) {
        return response()->json(['error' => 'Failed to get access token'], 500);
    }

    $stkPushUrl = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $accessToken,
        'Content-Type' => 'application/json',
    ])->post($stkPushUrl, [
        "BusinessShortCode" => $this->shortCode,
        "Password" => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => $amount,
        "PartyA" => $phone,
        "PartyB" => $this->shortCode,
        "PhoneNumber" => $phone,
        "CallBackURL" => "https://c872-197-237-175-62.ngrok-free.app/api/mpesa/callback",
        "AccountReference" => "BEACON CHILDREN'S CENTRE",
        "TransactionDesc" => "Payment for Invoice ID: " . $invoice->id
    ]);

    if ($response->successful()) {
        $responseData = $response->json();
        $checkoutRequestID = $responseData['CheckoutRequestID'] ?? null;

        if ($checkoutRequestID) {
            $invoice->checkout_request_id = $checkoutRequestID;
            $invoice->save();
        }

        return response()->json($responseData);
    } else {
        return response()->json(['error' => 'STK Push request failed'], 500);
    }
}

     public function callback(Request $request)
     {
         // Log the raw request data
         Log::info('Mpesa Callback Request Data:', $request->all());
     
         $data = $request->all();
         
         try {
             $mpesaResponse = json_decode(json_encode($data));
     
             if (!isset($mpesaResponse->Body->stkCallback)) {
                 // Log if the response is invalid
                 Log::warning('Invalid callback data received:', $mpesaResponse);
                 return response()->json(['error' => 'Invalid callback data'], 400);
             }
     
             $callback = $mpesaResponse->Body->stkCallback;
             $resultCode = $callback->ResultCode;
             $checkoutRequestID = $callback->CheckoutRequestID;
     
             // Log the result of the callback
             Log::info('Callback received. Result Code: ' . $resultCode . ', Checkout Request ID: ' . $checkoutRequestID);
     
             if ($resultCode == 0) {
                 $invoice = Invoice::where('checkout_request_id', $checkoutRequestID)->first();
     
                 if ($invoice) {
                     // Log the invoice found or not
                     Log::info('Invoice found for checkout_request_id ' . $checkoutRequestID);
     
                     if (!$invoice->invoice_status) {
                         $invoice->invoice_status = true;
                         $invoice->save();
     
                         // Log the invoice status update
                         Log::info('Invoice status updated to paid for invoice ID ' . $invoice->id);
     
                         // Broadcast event to update frontend in real-time
                         broadcast(new InvoicePaid($invoice))->toOthers();
                         Log::info('Invoice paid event broadcasted for invoice ID ' . $invoice->id);
                     } else {
                         Log::info('Invoice already marked as paid for invoice ID ' . $invoice->id);
                     }
                 } else {
                     Log::warning('Invoice not found for checkout_request_id ' . $checkoutRequestID);
                 }
             } else {
                 Log::warning('Non-zero result code received. Result Code: ' . $resultCode);
             }
         } catch (\Exception $e) {
             // Log the exception error message
             Log::error('Error processing callback: ' . $e->getMessage());
             return response()->json(['error' => 'Error processing callback'], 500);
         }
     
         return response()->json(['message' => 'Callback received']);
     }
     

}
