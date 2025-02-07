<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Import Log facade

class MpesaController extends Controller
{
    private $consumerKey = "fp3ojOyeuZreURK7vSnKsp4BnTm2aKrtj0LGuflU9uY5egDR";
    private $consumerSecret = "06X5NFq2OlXkTuTTOL4vAWYsXOJktlSzzxsq8kXJQGCWMa6fCwPPLFX4IqAwpoaO";
    private $shortCode = "174379";
    private $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
    private $callbackUrl = "https://0d7d-197-237-175-62.ngrok-free.app/mpesa/callback"; // Update with your real callback URL

    // Generate access token
    private function generateAccessToken()
    {
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)->get($url);
        
        Log::info('Access Token Response:', $response->json()); // Log the response for debugging
        
        return $response->json()['access_token'] ?? null;
    }

    // Initiate STK Push
    public function stkPush(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'phone' => 'required|regex:/^254[7-9][0-9]{8}$/'
        ]);

        $invoice = Invoice::find($request->invoice_id);
        
        // Check if invoice is found and if it is unpaid
        if (!$invoice || $invoice->invoice_status) {
            Log::warning('Invalid or already paid invoice ID: ' . $request->invoice_id); // Log warning
            return response()->json(['error' => 'Invalid or already paid invoice'], 400);
        }

        $amount = $invoice->total_amount;
        $phone = $request->phone;
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortCode . $this->passkey . $timestamp);

        $stkPushUrl = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
        $accessToken = $this->generateAccessToken();

        if (!$accessToken) {
            Log::error('Failed to retrieve access token'); // Log error
            return response()->json(['error' => 'Failed to get access token'], 500);
        }

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
            "CallBackURL" => $this->callbackUrl,
            "AccountReference" => "Hospital Invoice Payment",
            "TransactionDesc" => "Payment for Invoice ID: " . $invoice->id
        ]);

        Log::info('STK Push Response:', $response->json()); // Log the STK push response for debugging

        return response()->json($response->json());
    }

    // Handle Callback from Mpesa
    public function callback(Request $request)
    {
        $data = $request->all();
        Log::info('Mpesa Callback Data:', $data); // Log callback data for debugging
        
        $mpesaResponse = json_decode(json_encode($data));

        // Extract response data from the callback
        $resultCode = $mpesaResponse->Body->stkCallback->ResultCode;
        $checkoutRequestID = $mpesaResponse->Body->stkCallback->CheckoutRequestID;
        $merchantRequestID = $mpesaResponse->Body->stkCallback->MerchantRequestID;

        Log::info('Mpesa Callback Result:', [
            'ResultCode' => $resultCode,
            'CheckoutRequestID' => $checkoutRequestID,
            'MerchantRequestID' => $merchantRequestID
        ]); // Log the result of the callback for debugging

        if ($resultCode == 0) {
            // Retrieve transaction details
            $amount = $mpesaResponse->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $receiptNumber = $mpesaResponse->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            $phone = $mpesaResponse->Body->stkCallback->CallbackMetadata->Item[4]->Value;

            Log::info('Transaction Details:', [
                'Amount' => $amount,
                'ReceiptNumber' => $receiptNumber,
                'Phone' => $phone
            ]); // Log transaction details

            // Find the invoice by ID
            $invoice = Invoice::find($checkoutRequestID);

            if ($invoice && !$invoice->invoice_status) {
                // Update invoice status to paid
                $invoice->invoice_status = true;
                $invoice->save();
                Log::info('Invoice marked as paid:', ['InvoiceID' => $invoice->id]);
            } else {
                Log::warning('Invoice not found or already paid:', ['CheckoutRequestID' => $checkoutRequestID]);
            }
        } else {
            Log::error('Mpesa Payment failed:', [
                'ResultCode' => $resultCode,
                'CheckoutRequestID' => $checkoutRequestID
            ]);
        }
        
        // Return a success response
        return response()->json(['message' => 'Callback received']);
    }
}
