<?php

namespace Database\Seeders;

use App\Constants\Codes;
use App\Constants\Ranges;
use App\Models\Candlestick;
use App\Services\BinanceService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

abstract class CandlestickSeeder extends Seeder
{
    protected array $rangesLookup = [
        '1M' => Ranges::MONTH,
        '1w' => Ranges::WEEK,
        '1d' => Ranges::DAY,
        '1m' => Ranges::MINUTE,
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $service = app(BinanceService::class);

        foreach (Codes::cases() as $code) {
            $candlesticks = $service->candlesticks($code, $this->getPeriod());

            $this->persist($code, $candlesticks);
        }
    }

    protected function persist(Codes $code, array $candlesticks): void
    {
        foreach ($candlesticks as $attributes) {
            Candlestick::query()->updateOrCreate([
                'code' => $code,
                'range' => $this->rangesLookup[$this->getPeriod()],
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

    abstract protected function getPeriod(): string;
}
