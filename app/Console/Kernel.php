<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         Commands\GetCurrenciesRates::class,
         Commands\GetCriptocurrencyRate::class,
         Commands\GetBalanceForHistory::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('get_rates')->dailyAt('05:00');
        $schedule->command('get_balance')->monthlyOn(28,'04:00');

        $schedule->command('get_cripto_rate ethereum ETH')->cron('0 */12 * * *');
        $schedule->command('get_cripto_rate bitcoin BTC')->cron('0 */11 * * *');
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
}
