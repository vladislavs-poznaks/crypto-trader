<?php

namespace App\Console\Commands;

use App\Services\TransferVolumePredictionCalculationService;
use Illuminate\Console\Command;

class TransferVolumePredictionCalculationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vev:tvp-calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate TVP';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        resolve(TransferVolumePredictionCalculationService::class)->process();

        return 0;
    }

    public function __invoke ()
    {
        return $this->handle();
    }
}
