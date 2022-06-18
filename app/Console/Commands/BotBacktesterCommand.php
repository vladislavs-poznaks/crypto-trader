<?php

namespace App\Console\Commands;

use App\Constants\Code;
use App\Constants\Range;
use App\Models\Candlestick;
use App\Services\BotServiceInterface;
use Illuminate\Console\Command;

class BotBacktesterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vev:backtester {code=BTCBUSD} {range=day}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs backtester on existing candlesticks of particular coin with particular candlestick range';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $code = Code::from($this->argument('code'));
        $range = Range::from($this->argument('range'));

        $candlesticks = Candlestick::query()
            ->where('code', $code)
            ->where('range', $range)
            ->cursor();

        foreach ($candlesticks as $candlestick) {
            if (is_null($candlestick->open)) {
                continue;
            }

            $bot = app(BotServiceInterface::class, [
                'code' => $code,
                'price' => $candlestick->open,
                'datetime' => $candlestick->open_time
            ]);

            $bot->process();
        }

        return 0;
    }
}
