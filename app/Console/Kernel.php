<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     * 
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

     
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('sessions:clean')->daily();



        $schedule->command('reminders:send')
            ->everyMinute()
            ->when(function () {
                $time = now()->format('H:i');
                $allowedTimes = ['07:50', '07:51', '07:52', '07:53', '07:54', '07:55'];
        
                // Ensure it runs only once in this time frame
                return in_array($time, $allowedTimes) && Cache::add('reminder_sent_today', true, now()->addMinutes(10));
            });
        


        $schedule->command('sms:send')->dailyAt('08:00'); 
    }



    /**
     * Register the commands for the application.
     * 
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
