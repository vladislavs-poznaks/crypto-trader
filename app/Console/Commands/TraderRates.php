<?php

namespace App\Console\Commands;

use App\Constants\Code;
use App\Models\Rate;
use App\Services\BinanceService;
use Illuminate\Console\Command;

class TraderRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trader:rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets rates of particular coins';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rates = [
            Code::BTC_BUSD->value => [
                'source' => 'BUSD',
                'target' => 'BTC',
            ],
            Code::ETH_BUSD->value => [
                'source' => 'BUSD',
                'target' => 'ETH',
            ],
        ];

        $service = app(BinanceService::class);

        $prices = $service->getPrices();

        foreach ($prices as $code => $price) {
            if (in_array($code, array_keys($rates))) {
                Rate::create([
                    'code' => $code,
                    'source' => $rates[$code]['source'],
                    'target' => $rates[$code]['target'],
                    'rate' => $price,
                ]);
            }
        }

        return 0;
    }
}
