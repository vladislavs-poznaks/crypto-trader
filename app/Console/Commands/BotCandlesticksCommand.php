<?php

namespace App\Console\Commands;

use App\Constants\Code;
use App\Constants\Range;
use App\Models\Candlestick;
use App\Services\ExchangeServiceInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BotCandlesticksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vev:candlesticks {code=BTCBUSD}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets candlesticks of particular coin';

    protected array $rangesLookup = [
        '1M' => Range::MONTH,
        '1w' => Range::WEEK,
        '1d' => Range::DAY,
        '1h' => Range::HOUR,
        '1m' => Range::MINUTE,
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $code = Code::from($this->argument('code'));

        $exchange = app(ExchangeServiceInterface::class);

        foreach ($this->rangesLookup as $key => $range) {
            $candlesticks = $exchange->candlesticks($code, $key);

            $this->persist($code, $candlesticks, $key);
        }

        return 0;
    }

    protected function persist(Code $code, array $candlesticks, string $key): void
    {
        foreach ($candlesticks as $attributes) {
            Candlestick::query()->updateOrCreate([
                'code' => $code,
                'range' => $this->rangesLookup[$key],
                'open_time' => Carbon::createFromTimestamp($attributes['openTime'] / 1000),
                'close_time' => Carbon::createFromTimestamp($attributes['closeTime'] / 1000),
            ], [
                'open' => $attributes['open'],
                'close' => $attributes['close'],
                'close_open_difference' => $attributes['close'] - $attributes['open'],
                'low' => $attributes['low'],
                'high' => $attributes['high'],
                'high_low_difference' => $attributes['high'] - $attributes['low'],
                'volume' => $attributes['volume'],
                'asset_volume' =>  $attributes['assetVolume'],
                'base_volume' => $attributes['baseVolume'],
                'trades' => $attributes['trades'],
                'asset_buy_volume' => $attributes['assetBuyVolume'],
                'taker_buy_volume' => $attributes['takerBuyVolume'],
                'ignored' => $attributes['ignored'],
            ]);
        }
    }
}
