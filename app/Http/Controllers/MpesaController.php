<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        Log::info("🔐 Generating Mpesa access token...");

        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)->get($url);

        if ($response->successful()) {
            $accessToken = $response->json()['access_token'] ?? null;
            Log::info("✅ Access Token Generated: " . $accessToken);
            return $accessToken;
        } else {
            Log::error("❌ Failed to retrieve access token", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return null;
        }
    }

    /**
     * Initiate STK Push
     */
    public function stkPush(Request $request)
    {
        Log::info("📲 Received STK Push request", ['request_data' => $request->all()]);

        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'phone' => ['required', 'regex:/^254(1|7)[0-9]{8}$/']
        ]);

        $invoice = Invoice::find($request->invoice_id);

        if (!$invoice || $invoice->invoice_status) {
            Log::warning("⚠️ Invalid or already paid invoice", ['invoice_id' => $request->invoice_id]);
            return response()->json(['error' => 'Invalid or already paid invoice'], 400);
        }

        $amount = (int) $invoice->total_amount;

        if ($amount <= 0) {
            Log::error("❌ Invalid amount for STK Push", ['amount' => $amount]);
            return response()->json(['error' => 'Invalid amount'], 400);
        }

        $phone = $request->phone;
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortCode . $this->passkey . $timestamp);

        Log::info("📦 Preparing STK Push request", [
            'invoice_id' => $invoice->id,
            'amount' => $amount,
            'phone' => $phone
        ]);

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
                Log::info("💾 CheckoutRequestID saved", ['InvoiceID' => $invoice->id, 'CheckoutRequestID' => $checkoutRequestID]);
            }

            return response()->json($responseData);
        } else {
            Log::error("❌ STK Push request failed", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return response()->json(['error' => 'STK Push request failed'], 500);
        }
    }

    /**
     * Handle STK Callback
     */
    public function callback(Request $request)
    {
        $data = $request->all();
        Log::info("📥 Received Mpesa Callback", ['data' => $data]);

        try {
            $mpesaResponse = json_decode(json_encode($data));

            if (!isset($mpesaResponse->Body->stkCallback)) {
                Log::error("❌ Invalid callback structure", ['data' => $data]);
                return response()->json(['error' => 'Invalid callback data'], 400);
            }

            $callback = $mpesaResponse->Body->stkCallback;
            $resultCode = $callback->ResultCode;
            $checkoutRequestID = $callback->CheckoutRequestID;
            $merchantRequestID = $callback->MerchantRequestID;

            Log::info("📊 Mpesa Callback Result", [
                'ResultCode' => $resultCode,
                'CheckoutRequestID' => $checkoutRequestID,
                'MerchantRequestID' => $merchantRequestID
            ]);

            if ($resultCode == 0) {
                $metadata = $callback->CallbackMetadata->Item ?? [];

                $amount = null;
                $receiptNumber = null;
                $phone = null;

                foreach ($metadata as $item) {
                    if ($item->Name === "Amount") {
                        $amount = $item->Value;
                    } elseif ($item->Name === "MpesaReceiptNumber") {
                        $receiptNumber = $item->Value;
                    } elseif ($item->Name === "PhoneNumber") {
                        $phone = $item->Value;
                    }
                }

                Log::info("💰 Transaction Details", [
                    'Amount' => $amount,
                    'ReceiptNumber' => $receiptNumber,
                    'Phone' => $phone
                ]);

                // Find the invoice using checkout_request_id
                $invoice = Invoice::where('checkout_request_id', $checkoutRequestID)->first();

                if ($invoice && !$invoice->invoice_status) {
                    $invoice->invoice_status = true;
                    $invoice->save();
                    Log::info("✅ Invoice Marked as Paid", ['InvoiceID' => $invoice->id]);
                } else {
                    Log::warning("⚠️ Invoice not found or already paid", ['CheckoutRequestID' => $checkoutRequestID]);
                }
            } else {
                Log::error("❌ Mpesa Payment Failed", [
                    'ResultCode' => $resultCode,
                    'CheckoutRequestID' => $checkoutRequestID
                ]);
            }
        } catch (\Exception $e) {
            Log::error("❌ Error Processing Callback", ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error processing callback'], 500);
        }

        return response()->json(['message' => 'Callback received']);
    }
}
