<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SMSController;

class SendSMSReminders extends Command
{
    protected $signature = 'sms:send'; // ✅ Keep command name
    protected $description = 'Send daily SMS appointment reminders to users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info("⏳ Running SMS reminder command...");
        
        // Call the sendReminder method from SMSController
        app(SMSController::class)->sendReminder();

        Log::info("✅ SMS reminders process completed.");
    }
}
