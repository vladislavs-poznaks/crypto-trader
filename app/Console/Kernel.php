<?php

namespace App\Console;

use App\Console\Commands\BotTradeCommand;
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
//
//            $schedule->command("vev:candlesticks {$code->value}")
//                ->hourly();

            $schedule->command("vev:trade {$code->value}")
                ->everyMinute();

//            $schedule->call(BotTradeCommand::class, [
//                'code' => $code->value
//            ])
//                ->everyMinute();

            $schedule->call(new RSICalculationCommand)
                ->everyMinute();

            $schedule->call(new TransferVolumePredictionCalculationCommand)
                ->everyMinute();
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
