<?php

namespace App\Console\Commands;

use App\Models\ActiveUser;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanOldSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old user sessions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ActiveUser::where('last_activity', '<', Carbon::now()->subHours(24))->delete();
        $this->info('Old Sessions Cleaned Successfully');
    }
}
