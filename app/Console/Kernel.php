<?php

namespace App\Console;

use App\Console\Commands\GlassNodeCommand;
use App\Console\Commands\RSICalculationCommand;
use App\Console\Commands\TransferVolumePredictionCalculationCommand;
use App\Constants\Code;
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
        $codes = Code::cases();

        foreach ($codes as $code) {
//            $schedule->command("vev:rates {$code->value}")
//                ->everyMinute();

            $schedule->command("vev:trade {$code->value}")
                ->everyMinute();

            $schedule->call(new RSICalculationCommand)
                ->everyMinute();

            $schedule->call(new TransferVolumePredictionCalculationCommand)
                ->everyMinute();

            $schedule->call(new GlassNodeCommand('BTC', '24h', '1day'))
                ->daily();

            $schedule->call(new GlassNodeCommand('BTC', '1w', '1week'))
                ->weekly();

            $schedule->call(new GlassNodeCommand('BTC', '1month', '1month'))
                ->monthly();
        }
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
