<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('scentq:subscription_order')->daily();
        $schedule->command('scout:flush "App\Models\Product"')->daily();
        $schedule->command('scout:import "App\Models\Product"')->daily();
        $schedule->command('review-mail:send')->dailyAt('01:00');
        $schedule->command('product:update-review-ratings')->twiceDaily(3, 10);
        $schedule->command('telescope:prune --hours=48')->daily();
        $schedule->command('queue-fill-up:automatic')->daily();
        $schedule->command('order-fill-up:automatic')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    // protected $commands = [
    //     \App\Console\Commands\NotificationTemplates::class,
    // ];
}
