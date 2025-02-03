<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class LogoutUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:logout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log out the current authenticated user';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Log out the user without relying on session data
        Auth::logout();
        
        // Optionally, regenerate the session token if needed
        session()->regenerateToken();
        
        $this->info('User has been logged out.');
    }
}
