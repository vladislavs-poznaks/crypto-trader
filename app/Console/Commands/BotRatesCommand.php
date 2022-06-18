<?php

namespace App\Console\Commands;

use App\Constants\Code;
use App\Models\Rate;
use App\Services\BinanceService;
use App\Services\BotServiceInterface;
use App\Services\ExchangeServiceInterface;
use Illuminate\Console\Command;

class BotRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vev:rates {code=BTCBUSD}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets rates of particular coin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $code = Code::from($this->argument('code'));

        $exchange = app(ExchangeServiceInterface::class);

        $price = $exchange->getPrice($code);

        Rate::create([
            'code' => $code,
            'source' => $code->source(),
            'target' => $code->target(),
            'rate' => $price,
        ]);

        return 0;
    }
}
