<?php


namespace App\Services;

use AfricasTalking\SDK\AfricasTalking;

class AfricasTalkingService
{
    protected $AT;
    protected $sms;

    public function __construct()
    {
        $username = config('services.africastalking.username');
        $apiKey = config('services.africastalking.api_key');

        $this->AT = new AfricasTalking($username, $apiKey);
        $this->sms = $this->AT->sms();
    }

    public function sendSMS($recipients, $message, $senderId = null)
    {
        try {
            $response = $this->sms->send([
                'to'      => $recipients,
                'message' => $message,
                'from'    => $senderId // Optional Sender ID (must be approved)
            ]);

            return $response;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
