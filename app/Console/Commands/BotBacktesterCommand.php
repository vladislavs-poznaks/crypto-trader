<?php

namespace App\Console\Commands;

use App\Constants\Code;
use App\Constants\Range;
use App\Models\Candlestick;
use App\Models\Order;
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
        Order::query()->forceDelete();

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

            $orders = Order::query()
                ->where('code', $code)
                ->whereNull('sell_price')
                ->get();

            foreach ($orders as $order) {
                echo "Diff: ". ($candlestick->open / $order->price) . PHP_EOL;

                // Sell with profit
                if ($candlestick->open > $order->profit_limit_price) {
                    $this->line('<fg=green>SELL WITH PROFIT.</>');
                    $order->update([
                        'sell_price' => $candlestick->open
                    ]);
                }
                // Sell with loss
                if ($candlestick->open < $order->loss_limit_price) {
                    $this->line('<fg=red>SELL WITH LOSS.</>');
                    $order->update([
                        'sell_price' => $candlestick->open
                    ]);
                }
            }

            $bot = app(BotServiceInterface::class, [
                'code' => $code,
                'price' => $candlestick->open,
                'datetime' => $candlestick->open_time
            ]);

            $bot->process();
        }

        $buySum = Order::query()
            ->sum('price');

        $sellSum = Order::query()
            ->sum('sell_price');

        $profitability = $sellSum / $buySum;

        $color = $profitability > 1 ? 'green' : 'red';

        $this->line("<bg={$color}>Profitability: {$profitability}</>");

        return 0;
    }
}
