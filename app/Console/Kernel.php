<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
		$schedule->command('app:email-command')->everySecond();
		$schedule->command('app:transaction-command')->everyTenMinutes();
		$schedule->command('app:twitter-command')->everyTenMinutes();
		$schedule->command('app:etherscan-command')->everyTenMinutes();
		$schedule->command('app:kol-command')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
