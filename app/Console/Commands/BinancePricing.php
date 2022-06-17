<?php

namespace App\Console\Commands;

use Binance\API;
use Illuminate\Console\Command;

class BinancePricing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trader:pricing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets prices of particular coin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new API(config('services.binance.key'), config('services.binance.secret'));

        while (true) {
            $ticker = $api->price("LTCUSDT");
            print_r($ticker);

            sleep(1);
        }

        return 0;
    }
}
