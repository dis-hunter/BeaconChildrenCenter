<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\MailController;

class SendAppointmentReminders extends Command
{
    protected $signature = 'reminders:send'; // The command name
    protected $description = 'Send appointment reminder emails automatically';

    public function handle()
    {
        Log::info("⏳ Running scheduled appointment reminders...");
        
        // Call the sendReminder method from MailController
        app(MailController::class)->sendReminder();
        
        Log::info("✅ Appointment reminders process completed.");
    }
}
