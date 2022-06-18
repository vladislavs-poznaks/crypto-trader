<?php

namespace App\Console\Commands;

use App\Constants\Code;
use App\Services\BotServiceInterface;
use App\Services\ExchangeServiceInterface;
use App\Services\RSICalculationService;
use Illuminate\Console\Command;

class RSICalculationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vev:rsi-calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate RSI';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        resolve(RSICalculationService::class)->process();

        return 0;
    }

    public function __invoke ()
    {
        return $this->handle();
    }
}
